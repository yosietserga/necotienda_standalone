<?php
class ControllerStoreSearch extends Controller {

    public function index() {
        $this->session->clear('object_type');
        $this->session->clear('object_id');
        $this->session->clear('landing_page');

        $criteria = array();
        $criteria['page'] = $this->request->hasQuery('page') ? $this->request->getQuery('page') : 1;
        $criteria['sort'] = $this->request->hasQuery('sort') ? $this->request->getQuery('sort') : 'pd.name';
        $criteria['order'] = $this->request->hasQuery('order') ? $this->request->getQuery('order') : 'ASC';
        $criteria['limit'] = $this->request->hasQuery('limit') ? $this->request->getQuery('limit') : $this->config->get('config_catalog_limit');
        $criteria['start'] = ($criteria['page'] - 1) * $criteria['limit'];

        $this->data['urlQuery'] = array();
        $this->data['urlQuery']['page'] = ($this->request->hasQuery('page')) ? '&page=' . $this->request->getQuery('page') : '';
        $this->data['urlQuery']['sort'] = ($this->request->hasQuery('sort')) ? '&sort=' . $this->request->getQuery('sort') : '';
        $this->data['urlQuery']['order'] = ($this->request->hasQuery('order')) ? '&order=' . $this->request->getQuery('order') : '';
        $this->data['urlQuery']['limit'] = ($this->request->hasQuery('limit')) ? '&limit=' . $this->request->getQuery('limit') : '';

        if ($this->config->get('config_seo_url')) {
            $this->data['urlBase'] = HTTP_HOME . 'buscar/' . $_GET['q'];
            $this->data['urlSearch'] = HTTP_HOME . 'buscar/' . $_GET['q'] . '?' . implode('', $this->data['urlQuery']);
        } else {
            $this->data['urlBase'] = HTTP_HOME . 'index.php?r=store/search&q=' . $_GET['q'];
            $this->data['urlSearch'] = HTTP_HOME . 'index.php?r=store/search&q=' . $_GET['q'] . '&' . implode('', $this->data['urlQuery']);
        }

        //tracker
        $this->tracker->track(0, 'search_page');

        if ($this->session->has('ref_email') && !$this->session->has('ref_cid')) {
            $this->data['show_register_form_invitation'] = true;
        }

        $cacheId = 'html-search_page_' . md5($this->data['urlSearch']) .
            serialize($this->request->get).
            $this->config->get('config_language_id') . "." .
            $this->request->getQuery('hl') . "." .
            $this->request->getQuery('cc') . "." .
            $this->customer->getId() . "." .
            $this->config->get('config_currency') . "." .
            (int) $this->config->get('config_store_id');

        $this->load->library('user');
        $cached = $this->cache->get($cacheId);
        if ($cached && !$this->user->isLogged()) {
            $this->response->setOutput($cached, $this->config->get('config_compression'));
        } else {
            $this->language->load('store/search');
            $this->load->model("store/search");

            $this->document->breadcrumbs = array();
            $this->document->breadcrumbs[] = array(
                'href' => Url::createUrl("common/home"),
                'text' => $this->language->get('text_home'),
                'separator' => false
            );

            $this->data['urlCriterias'] = array();

            list($keyword) = explode('_', $_GET['q']);
            $params = explode('_', strtolower($_GET['q']));
            $queries[1] = $queries[2] = trim(trim($params[0], '-'));

            $this->data['urlCriterias']['forCategories'] = $this->data['urlCriterias']['forZones'] = $this->data['urlCriterias']['forSellers'] = $this->data['urlCriterias']['forManufacturers'] = $this->data['urlCriterias']['forStores'] = $this->data['urlCriterias']['forPrices'] = $this->data['urlCriterias']['forShipping'] = $this->data['urlCriterias']['forPayments'] = $this->data['urlCriterias']['forStatus'] = $this->data['urlCriterias']['forStockStatus'] = $this->data['urlCriterias']['forDates'] = $this->data['urlCriterias']['forAttributes'] = $queries[1];

            $this->document->title = $this->data['heading_title'] = $this->language->get('heading_title') . ' ' . str_replace('-', ' ', $keyword);

            if (in_array('cat', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'cat') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['category'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forZones'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Cat_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Cat_' . $name;
            }

            if (in_array('estado', $params)) {
                $this->load->model('localisation/zone');
                foreach ($params as $key => $value) {
                    if ($value == 'estado') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['zone'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Estado_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Estado_' . $name;
            }

            if (in_array('vendedor', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'vendedor') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['seller'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Vendedor_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Vendedor_' . $name;
            }

            if (in_array('marca', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'marca') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['manufacturer'] = $name;

                $this->data['urlCriterias']['forCategories'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Marca_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Marca_' . $name;
            }

            if (in_array('tienda', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'tienda') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['stores'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Tienda_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Tienda_' . $name;
            }

            if (in_array('precio', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'precio') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                list($criteria['price_start'], $criteria['price_end']) = explode('-', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Precio_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Precio_' . $name;
            }

            if (in_array('envio', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'envio') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['shipping_method'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Envio_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Envio_' . $name;
            }

            if (in_array('pago', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'pago') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['payment_method'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Pago_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Pago_' . $name;
            }

            if (in_array('disp', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'disp') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['stock_status'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Disp_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Disp_' . $name;
            }

            if (in_array('status', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'status') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $criteria['product_status'] = str_replace('-', ' ', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forDates'] .= '_Status_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Status_' . $name;
            }

            if (in_array('fecha', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'fecha') {
                        $name = $params[$key + 1];
                        unset($params[$key], $params[$key + 1]);
                    }
                }
                //TODO: clean the query
                $name = str_replace(' ', '+', trim($name));
                list($criteria['date_start'], $criteria['date_end']) = explode('+', $name);

                $this->data['urlCriterias']['forCategories'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forZones'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forSellers'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forManufacturers'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forStores'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forPrices'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forShipping'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forPayments'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forStatus'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forStockStatus'] .= '_Fecha_' . $name;
                $this->data['urlCriterias']['forAttributes'] .= '_Fecha_' . $name;
            }

            if (in_array('filtro', $params)) {
                foreach ($params as $key => $value) {
                    if ($value == 'filtro') {
                        $name = str_replace(' ', '+', trim($params[$key + 1]));
                        list($property_key, $property_value) = explode('+', $name);
                        if (!empty($property_value)) {
                            $criteria['properties'][$key]['key'] = $property_key;
                            $criteria['properties'][$key]['value'] = $property_value;
                            unset($params[$key], $params[$key + 1]);
                            $this->data['urlCriterias']['forCategories'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forZones'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forSellers'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forManufacturers'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forStores'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forPrices'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forShipping'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forPayments'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forStatus'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forStockStatus'] .= '_Filtro_' . $name;
                            $this->data['urlCriterias']['forDates'] .= '_Filtro_' . $name;
                        }
                    }
                }
                //TODO: clean the query
            }

            $criteria['queries'] = array_unique($queries);

            if (isset($criteria['category'])) {
                $this->data['filters']['category'] = array(
                    'name' => $criteria['category'],
                    'href' => rtrim($this->data['urlCriterias']['forCategories'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['zone'])) {
                $this->data['filters']['zone'] = array(
                    'name' => $criteria['zone'],
                    'href' => rtrim($this->data['urlCriterias']['forZones'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['seller'])) {
                $this->data['filters']['seller'] = array(
                    'name' => $criteria['seller'],
                    'href' => rtrim($this->data['urlCriterias']['forSellers'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['manufacturer'])) {
                $this->data['filters']['manufacturer'] = array(
                    'name' => $criteria['manufacturer'],
                    'href' => rtrim($this->data['urlCriterias']['forManufacturers'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['stores'])) {
                $this->data['filters']['stores'] = array(
                    'name' => $criteria['stores'],
                    'href' => rtrim($this->data['urlCriterias']['forStores'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['shipping_methods'])) {
                $this->data['filters']['shipping_methods'] = array(
                    'name' => $criteria['shipping_methods'],
                    'href' => rtrim($this->data['urlCriterias']['forShippingMethods'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['payment_methods'])) {
                $this->data['filters']['payment_methods'] = array(
                    'name' => $criteria['payment_methods'],
                    'href' => rtrim($this->data['urlCriterias']['forPaymentMethods'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['stock_statuses'])) {
                $this->data['filters']['stock_statuses'] = array(
                    'name' => $criteria['stock_statuses'],
                    'href' => rtrim($this->data['urlCriterias']['forStockStatuses'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['status'])) {
                $this->data['filters']['status'] = array(
                    'name' => $criteria['status'],
                    'href' => rtrim($this->data['urlCriterias']['forStatus'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['properties'])) {
                foreach ($criteria['properties'] as $key => $value) {
                    $this->data['filters']['properties'][$key] = array(
                        'name' => $value['value'],
                        'href' => rtrim($this->data['urlCriterias']['forAttributes'] . '?' . implode('', $this->data['urlQuery']), '?')
                    );
                }
            }
            if (isset($criteria['price_start']) && isset($criteria['price_end'])) {
                $this->data['filters']['price'] = array(
                    'name' => $this->currency->format($this->tax->calculate($criteria['price_start'])) . ' - ' .
                    $this->currency->format($this->tax->calculate($criteria['price_end'])),
                    'href' => rtrim($this->data['urlCriterias']['forPrices'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }
            if (isset($criteria['date_start']) && isset($criteria['date_end'])) {
                $this->data['filters']['date'] = array(
                    'name' => $criteria['date_start'] . ' / ' . $criteria['date_end'],
                    'href' => rtrim($this->data['urlCriterias']['forDates'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            } elseif (isset($criteria['date_start'])) {
                $this->data['filters']['date'] = array(
                    'name' => $criteria['date_start'] . ' / ' . date('d-m-Y'),
                    'href' => rtrim($this->data['urlCriterias']['forDates'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            } elseif (isset($criteria['date_end'])) {
                $this->data['filters']['date'] = array(
                    'name' => date('d-m-Y') . ' / ' . $criteria['date_end'],
                    'href' => rtrim($this->data['urlCriterias']['forDates'] . '?' . implode('', $this->data['urlQuery']), '?')
                );
            }

            $sortDeafultQuery = "";
            $sortDeafultQuery .= $this->data['urlQuery']['page'];
            $sortDeafultQuery .= $this->data['urlQuery']['limit'];
            $sortOrderAscQuery = $this->data['urlBase'] . '?&sort=p.sort_order&order=ASC' . $sortDeafultQuery;
            $nameAscQuery = $this->data['urlBase'] . '?&sort=pd.name&order=ASC' . $sortDeafultQuery;
            $nameDescQuery = $this->data['urlBase'] . '?&sort=pd.name&order=ASC' . $sortDeafultQuery;
            $priceAscQuery = $this->data['urlBase'] . '?&sort=p.price&order=ASC' . $sortDeafultQuery;
            $priceDescQuery = $this->data['urlBase'] . '?&sort=p.price&order=ASC' . $sortDeafultQuery;
            $productRatingAscQuery = $this->data['urlBase'] . '?&sort=p.rating&order=ASC' . $sortDeafultQuery;
            $productRatingDescQuery = $this->data['urlBase'] . '?&sort=p.rating&order=ASC' . $sortDeafultQuery;

            $this->data['sorts'] = array();
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $sortOrderAscQuery
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $nameAscQuery
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $nameDescQuery
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $priceAscQuery
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $priceDescQuery
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_rating_asc'),
                'value' => 'p.rating-ASC',
                'href' => $productRatingAscQuery
            );
            $this->data['sorts'][] = array(
                'text' => $this->language->get('text_rating_desc'),
                'value' => 'p.rating-DESC',
                'href' => $productRatingDescQuery
            );

            $this->load->model('store/search');
            $total = $this->modelSearch->getAllProductsTotal($criteria);
            if ($total) {

                if (!$criteria['categories'])
                    $this->data['filterCategories'] = $this->modelSearch->getCategoriesByProduct($criteria);
                if (!$criteria['manufacturer'])
                    $this->data['filterManufacturers'] = $this->modelSearch->getManufacturersByProduct($criteria);
                if (!$criteria['zone'])
                    $this->data['filterZones'] = $this->modelSearch->getZonesByProduct($criteria);
                if (!$criteria['stores'])
                    $this->data['filterStores'] = $this->modelSearch->getStoresByProduct($criteria);

                $results = $this->modelSearch->getAllProducts($criteria);

                $this->load->auto('store/review');
                $this->data['products'] = array();
                $topPrice = 0;
                $bottomPrice = 1000000000;
                foreach ($results as $result) {
                    $image = !empty($result['image']) ? $result['image'] : 'no_image.jpg';

                    $rating = ($this->config->get('config_review')) ? $this->modelReview->getAverageRating($result['product_id']) : false;


                    if ($result['price'] > $topPrice) {
                        $this->data['topPrice'] = array(
                            'value' => $result['price'],
                            'tax_class_id' => $result['tax_class_id']
                        );
                        $topPrice = $result['price'];
                    }

                    if ($result['price'] < $bottomPrice) {
                        $this->data['bottomPrice'] = array(
                            'value' => $result['price'],
                            'tax_class_id' => $result['tax_class_id']
                        );
                        $bottomPrice = $result['price'];
                    }

                    $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));

                    $this->load->auto('image');
                    $this->data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'name' => $result['name'],
                        'model' => $result['model'],
                        'overview' => $result['meta_description'],
                        'rating' => $rating,
                        'stars' => sprintf($this->language->get('text_stars'), $rating),
                        'price' => $price,
                        'image' => NTImage::resizeAndSave($image, 38, 38),
                        'lazyImage' => NTImage::resizeAndSave('no_image.jpg', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height')),
                        'thumb' => NTImage::resizeAndSave($image, $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'))
                    );
                }

                $topPrice = $this->data['topPrice']['value'];
                $bottomPrice = $this->data['bottomPrice']['value'];
                $diff = ($topPrice - $bottomPrice) * 0.20;
                if ($diff > 0) {
                    while (true) {
                        $topPrice = $bottomPrice + $diff - + 0.01;
                        if ($topPrice >= $this->data['topPrice']['value']) {
                            $topPrice = $this->data['topPrice']['value'];
                            $break = true;
                        }

                        $this->data['filterPrices'][] = array(
                            'bottomValue' => round($bottomPrice, 2),
                            'bottomText' => $this->currency->format($this->tax->calculate($bottomPrice, $this->data['topPrice']['tax_class_id'], $this->config->get('config_tax'))),
                            'topValue' => round($topPrice, 2),
                            'topText' => $this->currency->format($this->tax->calculate($topPrice, $this->data['topPrice']['tax_class_id'], $this->config->get('config_tax')))
                        );

                        if ($break)
                            break;
                        $bottomPrice = $topPrice + 0.01;
                    }
                }

                $this->load->library('pagination');
                $pagination = new Pagination(true);
                $pagination->total = $total;
                $pagination->page = $criteria['page'];
                $pagination->limit = $criteria['limit'];
                $pagination->text = $this->language->get('text_pagination');
                unset($this->data['urlQuery']['page']);
                $pagination->url = $this->data['urlBase'] . '?page={page}' . implode('', $this->data['urlQuery']);

                $this->session->set('redirect', $this->data['urlBase'] . '?page=' . $criteria['page'] . implode('', $this->data['urlQuery']));

                $this->data['pagination'] = $pagination->render();

                $this->modelSearch->add();
            } else {
                $this->data['noResults'] = true;
            }

            $this->data['breadcrumbs'] = $this->document->breadcrumbs;

            // SCRIPTS
            $scripts[] = array('id' => 'search-1', 'method' => 'ready', 'script' =>
                "$('#content_search input').keydown(function(e) {
                   	if (e.keyCode == 13 && $(this).val().length > 0) {
                  		contentSearch();
                   	}
                });
                if (window.location.hash.length > 0) {
                    $('#products').load('" . Url::createUrl("store/search") . "&q='+ window.location.hash.replace('#', ''));
                }");

            $this->session->set('landing_page','store/search');
            $this->loadWidgets('featuredContent');
            $this->loadWidgets('main');
            $this->loadWidgets('featuredFooter');

            $this->addChild('common/column_left');
            $this->addChild('common/column_right');
            $this->addChild('common/footer');
            $this->addChild('common/header');

            if (!$this->user->isLogged()) {
                $this->cacheId = $cacheId;
            }

            if ($scripts)
                $this->scripts = array_merge($this->scripts, $scripts);

            $template = ($this->config->get('default_view_search')) ? $this->config->get('default_view_search') : 'store/search.tpl';
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/' . $template)) {
                $this->template = $this->config->get('config_template') . '/' . $template;
            } else {
                $this->template = 'cuyagua/' . $template;
            }

            $this->response->setOutput($this->render(true), $this->config->get('config_compression'));
        }
    }
}