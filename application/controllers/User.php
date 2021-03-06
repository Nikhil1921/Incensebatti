<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Public_controller {
    public function __construct()
	{
		parent::__construct();
        if (! $this->session->userId)
            flashMsg(0, "", "Login to continue.", "login");
    }

    public function index()
	{
		$data['title'] = 'My account';
        $data['name'] = 'my-account';
        $data['orders'] = $this->main->getAll('orders', 'id, total_amount, shipping, o_date, status, pay_type, pay_staus, discount, details', ['u_id' => $this->session->userId]);
        // $data['address'] = $this->main->getAll('addresses', 'id, address, pincode', ['u_id' => $this->session->userId]);
        // $data['breadcrumb'] = $this->breadcrumb.'my-account.jpg';
        
		return $this->template->load('template', 'user/my-account', $data);
	}

    public function checkout()
	{
		$data['title'] = 'Checkout';
        $data['name'] = 'checkout';
        $data['address'] = $this->main->getAll('addresses', 'id, address, pincode', ['u_id' => $this->session->userId]);
        // $data['breadcrumb'] = $this->breadcrumb.'checkout.jpg';
        
		return $this->template->load('template', 'checkout', $data);
	}

    public function checkout_post()
	{
        check_ajax();

        $validate = [
            [
                'field' => 'fullname',
                'label' => 'Full name',
                'rules' => 'required|max_length[100]|alpha_numeric_spaces|trim',
                'errors' => [
                    'required' => "%s is required",
                    'max_length' => "Max 100 chars allowed.",
                    'alpha_numeric_spaces' => "Only characters and numbers are allowed."
                ]
            ],
            [
                'field' => 'mobile',
                'label' => 'Mobile',
                'rules' => 'required|exact_length[10]|integer|trim',
                'errors' => [
                    'required'     => "%s is required",
                    'exact_length' => "Invalid %s.",
                    'integer'      => "Invalid %s.",
                ]
            ],
            [
                'field' => 'pay_type',
                'label' => 'Payment Type',
                'rules' => 'required|max_length[16]|alpha_numeric_spaces|trim',
                'errors' => [
                    'required'             => "%s is required",
                    'max_length'           => "Invalid %s.",
                    'alpha_numeric_spaces' => "Invalid %s.",
                ]
            ],
            [
                'field' => 'add_id',
                'label' => 'address',
                'rules' => 'required|integer|trim',
                'errors' => [
                    'required'     => "Select %s.",
                    'integer'      => "Invalid %s.",
                ]
            ]
        ];
        
        $this->form_validation->set_rules($validate);

        if ($this->form_validation->run() == FALSE)
            $response = [
                'status'  => "error",
                'message' => validation_errors()
            ];
        else{
            $pincode = $this->main->check('addresses', ['id' => d_id($this->input->post('add_id'))], 'pincode');

            if ($del = $this->main->check('pincodes', ['pincode' => $pincode], 'del_charge'))
                if ($id = $this->main->saveOrder($del, $this->input->post()))
                    $response = [
                        'id'       => $id,
                        'status'   => "success",
                        'message'  => "Order success.",
                    ];
                else
                    $response = [
                        'status'   => "success",
                        'message'  => "Order not success. Try again",
                    ];
            else
                $response = [
                    'status'  => "error",
                    'message' => "Delivery not available for given pincode."
                ];
        }

        die(json_encode($response));
	}

    public function apply_coupon()
	{
        if (! $this->input->post('coupon_code')) {
            $id = 0;
            $success = '';
            $error = "Enter coupon code.";
        }else{
            $check = $this->main->get('coupon', 'coupon_code, coupon_discount', ['coupon_code' => $this->input->post('coupon_code')]);
            if (!$check) {
                $id = 0;
                $success = '';
                $error = "Invalid coupon code.";
            }else{
                $this->session->set_userdata($check);
                $id = 1;
                $success = 'Coupon code applied successfully.';
                $error = "";
            }
        }

        flashMsg($id, $success, $error, "checkout");
	}

    public function add_address()
    {
        check_ajax();

        $this->form_validation->set_rules('address', 'Address', 'required|max_length[255]', [
                'required'      => '%s is required.',
                'max_length'    => 'Max 255 chars allowed.']);

        $this->form_validation->set_rules('pincode', 'Pincode', 'required|exact_length[6]|integer', [
                'required'      => '%s is required.',
                'integer'       => '%s is invalid.',
                'exact_length'  => '%s is invalid.']);

        if ($this->form_validation->run() == FALSE)
            $response = [
                'status'  => "error",
                'message' => validation_errors()
            ];
        else{
            $del = $this->main->check('pincodes', ['pincode' => $this->input->post('pincode')], 'del_charge');
            if (! $del)
                $response = [
                    'status'  => "error",
                    'message' => "Delivery not available for given pincode."
                ];
            else{
                $post = [
                    'u_id'     => $this->session->userId,
                    'address'  => $this->input->post('address'),
                    'pincode'  => $this->input->post('pincode')
                ];

                if($this->main->add($post, 'addresses'))
                    $response = [
                        'status'  => "success",
                        'message' => "Address added successfully.",
                    ];
                else
                    $response = [
                        'status'  => "error",
                        'message' => "Address not added.",
                    ];
            }
        }

        die(json_encode($response));
    }

    public function check_address()
    {
        check_ajax();

        $pincode = $this->main->check('addresses', ['id' => d_id($this->input->get('add_id'))], 'pincode');
        
        if ($del = $this->main->check('pincodes', ['pincode' => $pincode], 'del_charge'))
            $response = [
                'status'   => "success",
                'charge'   => $del,
                'discount' => $this->session->coupon_discount ? $this->session->coupon_discount : 0,
                'message'  => "Delivery available for given address.",
            ];
        else
            $response = [
                'status'  => "error",
                'message' => "Delivery not available for given address.",
            ];

        die(json_encode($response));
    }

    public function order()
	{
        $data['title'] = 'Order';
        $data['name'] = 'order';
		$data['order'] = $this->main->get('orders', '*', ['id' => d_id($this->input->get('order')), 'is_deleted' => 0]);
        
		return $this->template->load('template', 'user/order', $data);
    }

    public function profile()
	{
        $this->form_validation->set_rules('fullname', 'Fullname', 'required|max_length[100]|trim', [
                'required'      => '%s is required.',
                'max_length'    => 'Max 100 characters allowed.']);

        $this->form_validation->set_rules('reg_mobile', 'Mobile No.', 'required|is_unique[users.mobile]|exact_length[10]|integer', [
                'required'      => '%s is required.',
                'exact_length'  => '%s is invalid.',
                'integer'       => '%s is invalid.',
                'is_unique'     => 'This %s already in use.']);
                
        if ($this->form_validation->run() == TRUE){
            
        }else{
            $data['title'] = 'Profile';
            $data['name'] = 'profile';
            $data['user'] = $this->main->get('users', 'fullname, mobile', ['id' => $this->session->userId]);
            
            return $this->template->load('template', 'user/profile', $data);
        }
    }

    public function logout()
	{
		$this->session->sess_destroy();
        return redirect('login');
    }
}