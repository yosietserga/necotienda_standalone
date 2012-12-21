<?php
class CronSend {
    
    /**
     * @var $registry
     * */
    protected $registry;
    
    /**
     * @var $load
     * */
    protected $load;
    
    /**
     * @var $config
     * */
    protected $config;
    
    /**
     * @var $db
     * */
    protected $db;
    
    /**
     * @var $mailer
     * */
    protected $mailer;
    
    /**
     * @var $cache
     * */
    protected $cache;
    
    public function __construct($registry) {
        $this->registry   = $registry;
        $this->load   = $registry->get('load');
        $this->mailer = $registry->get('mailer');
        $this->config = $registry->get('config');
        $this->cache  = $registry->get('cache');
        $this->db     = $registry->get('db');
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

    public function run($tasks) {
        foreach ($tasks as $key => $task) {
            if (isset($task->params['job']) && $task->params['job'] == 'send_campaign') {
                $this->sendCampaign($task);
            }
        }
        /**
         * 
         * array (
         * send_campaign,               // enviar campaña de email marketing
         * send_birthday,               // enviar felicitaciones de cumpleaños a todos los clientes que cumplan año
         * send_new_products,           // enviar boletín de productos nuevos
         * send_products_of_interest,   // enviar productos de interés para el cliente
         * send_special,                // enviar boletín con los productos en ofertas
         * send_new_private_sales       // enviar boletín con las nuevas ventas privadas
         * send_open_orders             // enviar notificación con todas las órdenes que no se han concretado o pedidos abiertos
         * send_inactive_customers      // enviar notificación a los clientes que están inactivos
         * send_unapproved_customers    // enviar notificación a los clientes que están pendientes por verificación
         * )
         * - 
         * */
    }
    
    public function sendCampaign($task) {
        if ($this->isLocked('send_campaign')) {
            $task->addMinute(15);
        } else {
            $task->start();
            $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."campaign c WHERE campaign_id = '". (int)$task->params['campaign_id'] ."'");
            
            $campign_info = $query->row;
            
            $htmlbody = html_entity_decode($this->cache->get("campaign.html." . (int)$task->params['campaign_id']));
            $count = 0;
            foreach ($task->getTaskQueue() as $key => $queue) {
                if ($count >= 50) {
                    break;
                }
                
                $params = unserialize($queue['params']);
        
                $htmlbody = str_replace("{%contact_id%}",$params['contact_id'],$htmlbody);
                $htmlbody = str_replace("{%campaign_id%}",$params['campaign_id'],$htmlbody);
                
                $this->mailer->AddAddress($params['email'],$params['name']);
                $this->mailer->IsHTML();
                $this->mailer->SetFrom($campign_info['from_email'],$campign_info['from_name']);
                $this->mailer->AddReplyTo($campign_info['replyto_email'],$campign_info['from_name']);
                $this->mailer->Subject = $campign_info['subject'];
                $this->mailer->Body = $htmlbody;
                $this->mailer->Send();
                
                $task->setQueueDone($key);
                $count++;
            }
            
            if ($task->getTaskDos()) {
                $task->addMinute(15);
            } else {
                $task->setTaskDone();
            }
            
        }
        
        $task->update();
        
        /**
         * - detectar la hora de la ejecución, si es mayor posponer tarea y actualizar el sort_order, si es menor y no se ha ejecutado, 
         * cambiar la hora de ejecución para más tarde, si la hora se pasa el siguiente día entonces actualizar la fecha completa
         * 
         * 
         * - comprobar que la cola de trabajo está libre o no está bloqueada
             * - si está bloqueada posponer time_exec 15 min a toda la tarea y la cola de trabajo
             * - si no lo está, bloquearla actualizando la tabla task_exec y continuar
                 * - obtener datos de la campaña (SQL)
                 * - dividir los contactos en grupos de 50
                 * - agregar los destinatarios al objeto mailer
                 * - enviar email
                 * - actualizar queue con status 0 para indicar que están listas
                 * - al enviar el grupo de cincuenta, 
                    * - comprobar o contar cuantas actividades faltan
                         * - si ya está lista, actualizar la tarea con status cero para indicar que ya fue enviada y actualizar el registro de la campaña y desbloquear la cola eliminando el registro de task_exec
                         * - sino
                             * - actualizar time_exec de la tarea sumando 15 min y time_last_exec con el tiempo ahora
                             * - actualizar toda la cola de trabajo agregando 15 min a las actividades pendientes
         * */
    }
    
    private function isLocked($job) {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX ."task_exec WHERE `type` = '". $this->db->escape($job) ."'");
        if (count($query->rows)) {
            return true;
        } else {
            return false;
        }
    }
}