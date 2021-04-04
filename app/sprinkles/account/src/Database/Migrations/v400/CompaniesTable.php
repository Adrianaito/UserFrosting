<?php

namespace UserFrosting\Sprinkle\Account\Database\Migrations\v400;

use Illuminate\Database\Schema\Blueprint;
use UserFrosting\Sprinkle\Core\Database\Migration;

class CompaniesTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('logo')->nullable(); //Path to logo file
            $table->string('website')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->collation = 'utf8_unicode_ci';
            $table->charset = 'utf8';
        });
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->drop('companies');
    }
}
