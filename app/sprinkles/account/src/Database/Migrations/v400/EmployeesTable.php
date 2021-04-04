<?php

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v400;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;
use UserFrosting\Sprinkle\Core\Facades\Seeder;

class EmployeesTable extends Migration
{
    public static $dependencies = [
        '\UserFrosting\Sprinkle\Account\Database\Migrations\v400\CompaniesTable',
    ];

    public function up()
    {
        $this->schema->create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('company')->unsigned(); //Foreign Key to Companies Table
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->foreign('company')->references('id')->on('companies');
            $table->charset = 'utf8';
        });
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('employees');
    }
}
