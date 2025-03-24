<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'contact_name',
    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'document' => 'required|string|unique:suppliers,document',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:2',
        'zip_code' => 'required|string|max:9',
        'contact_name' => 'required|string|max:255',
    ];
}
