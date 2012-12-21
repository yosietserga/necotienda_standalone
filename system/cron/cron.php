<?php
/**
 * 1. cargar la configuracion
 * 2. cargar las librerías necesarias
 * 3. inicializar las clases necesarias
 * 4. crear cron files para cada tipo de tarea
*/
echo "Begin cron process\n";
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app/admin/config_cron.php');
require_once(DIR_SYSTEM . 'startup.php');

require_once dirname(__FILE__) . '/api/send.php';
/*
require_once dirname(__FILE__) . '/api/sale.php';
require_once dirname(__FILE__) . '/api/bounce.php';
require_once dirname(__FILE__) . '/api/addons.php';
require_once dirname(__FILE__) . '/api/triggeremails.php';
require_once dirname(__FILE__) . '/api/maintenance.php';
*/

class Cron {
    /**
     * @var $registry
     * */
    protected $registry;
    
    /**
     * @var $loader
     * */
    protected $loader;
    
    /**
     * @var $config
     * */
    protected $config;
    
    /**
     * @var $db
     * */
    protected $db;
    
    /**
     * @var $cache
     * */
    protected $cache;
    
    /**
     * @var $timeZone
     * */
    protected $timeZone = "America/Caracas";
    
    /**
     * @var $tasks
     * */
    private $tasks = array();
    
    public function __construct() {
        $this->registry   = new Registry();
        $this->load = new Loader($this->registry);
        $this->config = new Config();
        $this->cache = new Cache();
        $this->db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        
        $this->registry->set('db', $this->db);
        $this->registry->set('load', $this->load);
        $this->registry->set('config', $this->config);
        $this->registry->set('cache', $this->cache);
        
        $this->load->library('task');
        $this->load->library('email/mailer');
        $this->load->library('email/pop3');
        $this->load->library('email/smtp');
        $this->load->library('email/utf8');
        
        $this->mailer       = new Mailer();
        $this->smtp         = new SMTP();
        $this->utf8         = new utf8();
        
        $this->registry->set('mailer', $this->mailer);
        
        $this->initConfig();
        $this->initMailer();
        
        $this->cronSend     = new CronSend($this->registry);
        /*
        $this->cronSale     = new CronSale($this->registry);
        $this->cronEnquiry  = new CronEnquiry($this->registry);
        $this->cronReport   = new CronReport($this->registry);
        $this->cronBackup   = new CronBackup($this->registry);
        $this->cronMaintenance = new CronMaintenance($this->registry);
        */
        
        $this->dt = new DateTime;
        $this->dt->setTimezone(new DateTimeZone($this->timeZone));
        
        $query = $this->db->query("SELECT * 
        FROM ". DB_PREFIX ."task 
        ORDER BY sort_order ASC, time_exec ASC");
        
        foreach ($query->rows as $key => $row) {
            $task = new Task($this->registry);
            $task->task_id          = $row['task_id'];
            $task->object_id        = $row['object_id'];
            $task->object_type      = $row['object_type'];
            $task->task             = $row['task'];
            $task->type             = $row['type'];
            $task->time_exec        = $row['time_exec'];
            $task->params           = unserialize($row['params']);
            $task->time_interval    = $row['time_interval'];
            $task->time_last_exec   = $row['time_last_exec'];
            $task->run_once         = $row['run_once'];
            $task->status           = $row['status'];
            $task->sort_order       = $row['sort_order'];
            $task->date_start_exec  = $row['date_start_exec'];
            $task->date_end_exec    = $row['date_end_exec'];
            
            $qry = $this->db->query("SELECT * 
            FROM ". DB_PREFIX ."task_queue t
            WHERE task_id = '". (int)$row['task_id'] ."' 
            AND status = 1
            ORDER BY sort_order ASC, time_exec ASC");
            
            foreach ($qry->rows as $queue) {
                $task->addQueue($queue);
            }
            
            $this->tasks[$task->task_id] = $task;
        }
    }
    
	public function __get($key) {
		return $this->registry->get($key);
	}

	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}

	public function __isset($key) {
		return $this->registry->has($key);
	}
    
    private function initConfig() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting");
        foreach ($query->rows as $setting) {
        	$this->config->set($setting['key'], $setting['value']);
        }
    }
    
    private function initMailer() {
        if ($this->config->get('config_smtp_method')=='smtp') {
            $this->mailer->IsSMTP();
            $this->mailer->Hostname = $this->config->get('config_smtp_host');
            $this->mailer->Username = $this->config->get('config_smtp_username');
            $this->mailer->Password = base64_decode($this->config->get('config_smtp_password'));
            $this->mailer->Port     = $this->config->get('config_smtp_port');
            $this->mailer->Timeout  = $this->config->get('config_smtp_timeout');
            $this->mailer->SMTPSecure = $this->config->get('config_smtp_ssl');
            $this->mailer->SMTPAuth = ($this->config->get('config_smtp_auth')) ? true : false;
         } elseif ($this->config->get('config_smtp_method')=='sendmail') {
            $this->mailer->IsSendmail();
         } else {
            $this->mailer->IsMail();
         }
    }
    
    public function run() {
        foreach ($this->tasks as $key => $task) {
            if ($task->type=='send') {
                $sendTasks[$key] = $task;
            }
            if (strpos($task->type, 'sale')) {
                $saleTasks[$key] = $task;
            }
            if (strpos($task->type, 'enquiry')) {
                $enquiryTasks[$key] = $task;
            }
            if (strpos($task->type, 'report')) {
                $reportTasks[$key] = $task;
            }
            if (strpos($task->type, 'backup')) {
                $backupTasks[$key] = $task;
            }
            if (strpos($task->type, 'maintenance')) {
                $maintenanceTasks[$key] = $task;
            }
            
        }
        
        if ($sendTasks) $this->cronSend->run($sendTasks);

        /*
        $this->cronReport->run();
        $this->cronBackup->run();
        $this->cronMaintenance->run();
        $this->cronSale->run();
        $this->cronEnquiry->run();
        */
    }
}

$cron = new Cron;
$cron->run();