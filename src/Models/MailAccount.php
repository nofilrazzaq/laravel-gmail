<?php

namespace Dacastro4\LaravelGmail\Models;

use Dacastro4\LaravelGmail\LaravelGmailClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'token',
        'account_type',
    ];

    public function gmailService()
    {
        return new LaravelGmailClass(config(), $this->id);
    }
}
