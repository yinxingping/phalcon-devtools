<?php

abstract class ControllerBase extends \Phalcon\Mvc\Controller
{
    protected $validation;
    protected $rules;
    protected $auth;

    public function onConstruct()
    {
        $this->validation = new \Phalcon\Validation();
        $this->auth = $this->session->get('auth');
        $this->addRules();
    }

    public function indexAction()
    {
        $this->sendContent('ok');
    }

    protected function sendContent($status, $messages=null)
    {
        if ($status == 'db_error' && is_array($messages)) {
            foreach ($messages as $message) {
                if ($message['type'] == 'Uniqueness') {
                    $status = 'unique_error';
                }
            }
        }

        $messages = $messages ?? STATUS[$status]['message'] ?? '';

        $this->response->setJsonContent([
            'code' => STATUS[$status]['code'],
            'status' => $status,
            'detail' => $messages,
        ]);

        $this->response->send();
    }

    protected function getMessages($messages)
    {
        $messageArray = [];
        foreach ($messages as $message) {
            $messageArray[] = [
                'field' => $message->getField(),
                'type' => $message->getType(),
                'code' => $message->getCode(),
                'message' => $message->getMessage(),
            ];
        }

        return $messageArray;
    }

    /*
     * 仅对需要过滤的参数进行验证
     */
    protected function getJsonRawBody(Array $useFields = [])
    {
        $params = $this->request->getJsonRawBody();
        $this->paramsHandler($params, $useFields);

        return $params;
    }

    protected function getQuery(Array $useFields = [])
    {
        $params = $this->request->getQuery();
        $params = (Object)$params; //由于之前取POST数据时取成了对象，这里处理成统一格式
        $this->paramsHandler($params, $useFields);

        return $params;
    }

    protected function addRules()
    {
        $this->rules = include_once(APP_PATH . '/config/rules.php');
    }

    //仅返回指定keys的字段,key不为数字时需要进行key转换
    protected function getPartData($data, $keys)
    {
        $newArr = [];
        foreach ($keys as $k => $v) {
            if (is_numeric($k)) {
                $newArr[$v] = is_array($data) ? $data[$v] : $data->$v;
            } else {
                $newArr[$v] = is_array($data) ? $data[$k] : $data->$k;
            }
        }

        return $newArr;
    }

    /*
     * 仅对需要过滤的参数进行验证
     */
    private function paramsHandler(&$params, &$useFields)
    {
        foreach ($params as $k=>$v) {
            if (!in_array($k, $useFields)) {
                unset($params->$k);
                continue;
            }
            if (is_string($v)) {
                $params->$k = trim($v);
            }
            if (is_numeric($v)) {
                $params->$k = (int)$v;
            }
        }

        $validators = [];
        foreach ($useFields as $field) {
            if (array_key_exists($field, $this->rules)) {
                $validators[] = [$field, $this->rules[$field]];
            }
        }

        if (count($validators) != 0) {
            $this->validation->setValidators($validators);
            $messages = $this->validation->validate($params);
            if ($messages->count() != 0) {
                $this->sendContent('valid_error', $this->getMessages($messages));
                exit;
            }
        }
    }

}

