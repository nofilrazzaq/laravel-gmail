<?php

namespace Dacastro4\LaravelGmail;

use Dacastro4\LaravelGmail\Exceptions\AuthException;
use Dacastro4\LaravelGmail\Services\Message;
use Illuminate\Support\Facades\Redirect;

class LaravelGmailClass extends GmailConnection
{
	public function __construct($config, $mailAccountId)
	{
		if (class_basename($config) === 'Application') {
			$config = $config['config'];
		}

		parent::__construct($config, $mailAccountId);
	}

	/**
	 * @return Message
	 * @throws AuthException
	 */
	public function message()
	{
		if (!$this->getToken()) {
			throw new AuthException('No credentials found.');
		}

		return new Message($this);
	}

	/**
	 * Returns the Gmail user email
	 *
	 * @return \Google_Service_Gmail_Profile
	 */
	public function user()
	{
		return $this->config('email');
	}

	/**
	 * Updates / sets the current mailAccountId for the service
	 *
	 * @return \Google_Service_Gmail_Profile
	 */
	public function setmailAccountId($mailAccountId)
	{
		$this->mailAccountId = $mailAccountId;
		return $this;
	}

	public function redirect()
	{
		return Redirect::to($this->getAuthUrl());
	}

	/**
	 * Gets the URL to authorize the user
	 *
	 * @return string
	 */
	public function getAuthUrl()
	{
		return $this->createAuthUrl();
	}

	public function logout()
	{
		$this->revokeToken();
		$this->deleteAccessToken();
	}

}
