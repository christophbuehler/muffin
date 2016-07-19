<?php

namespace Resources;

use Onyx\Http\PlainResponse;
use Onyx\Libs\Controller;
use Onyx\Libs\Session;
class LoginController extends Controller
{
    /**
     * GET
     * @return PlainResponse
     */
    function get(): PlainResponse
    {
        if (!$this->user->is_authenticated())
            return new PlainResponse("", 401);
        
        return new PlainResponse(sprintf('You are authenticated, %s!', $this->db->get('users')[$this->user->id]['name']));
    }

    /**
     * DELETE
     * @return PlainResponse
     */
    function delete(): PlainResponse
    {
        $this->user->logout();
        return new PlainResponse('You have been logged out!');
    }

    /**
     * POST
     * @return PlainResponse
     */
    function post(string $login, string $password): PlainResponse
    {
	    foreach ($this->db->get('users') as $id => $user) {
            if ($user['name'] == $login && $user['password'] == $password) {
                Session::set('userId', $id);
                return new PlainResponse('Login successful');
            }
        }
        return new PlainResponse('Authorization failed.', 401);
    }
}
