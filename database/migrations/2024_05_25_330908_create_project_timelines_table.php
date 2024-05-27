<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_timelines', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('year')->nullable();
            $table->integer('month')->nullable();

            $table->integer('project_id')->unsigned()->index();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->text('draft_link')->charset('utf8')->nullable();
            $table->text('client_feedback')->charset('utf8')->nullable();
            $table->text('admin_feedback')->charset('utf8')->nullable();
            $table->enum('round_draft', ['round1', 'round2', 'round3', 'done'])->charset('utf8')->default('round1');
            $table->enum('admin_status', ['approve', 'reject', 'waiting'])->charset('utf8')->default('waiting');
            $table->enum('client_status', ['approve', 'reject', 'waiting'])->charset('utf8')->default('waiting');


            $table->enum('draft_status', ['TRUE', 'FALSE', 'WAIT'])->charset('utf8')->default('WAIT');

            $table->date('post_date')->nullable();
            $table->enum('post_status', ['TRUE', 'FALSE', 'WAIT'])->charset('utf8')->default('WAIT');
            $table->text('post_link')->charset('utf8')->nullable();
            $table->text('post_code')->charset('utf8')->nullable();

            $table->integer('stat_view')->nullable();
            $table->integer('stat_like')->nullable();
            $table->integer('stat_comment')->nullable();
            $table->integer('stat_share')->nullable();

            $table->text('note1')->charset('utf8')->nullable();
            $table->text('contact')->charset('utf8')->nullable();
            $table->integer('pay_rate')->nullable();
            $table->integer('sum_rate')->nullable();
            $table->text('des_bill')->charset('utf8')->nullable();

            $table->integer('content_style_id')->nullable()->unsigned()->index();
            $table->foreign('content_style_id')->references('id')->on('content_style')->onDelete('cascade');

            $table->integer('vat')->nullable();
            $table->integer('withholding')->nullable();
            $table->integer('product_price')->nullable();
            $table->integer('transfer_amount')->nullable();
            $table->date('transfer_date')->nullable();

            $table->text('bank_account')->charset('utf8')->nullable();
            $table->integer('bank_id')->nullable();
            $table->text('bank_brand')->charset('utf8')->nullable();

            $table->string('name_of_card', 250)->charset('utf8')->nullable();
            $table->string('id_card', 250)->charset('utf8')->nullable();
            $table->text('address_of_card')->charset('utf8')->nullable();

            $table->text('product_address')->charset('utf8')->nullable();
            $table->string('line_id', 250)->charset('utf8')->nullable();
            $table->string('image_card', 255)->nullable()->charset('utf8');

            $table->text('transfer_email')->charset('utf8')->nullable();
            $table->text('transfer_link')->charset('utf8')->nullable();
            $table->string('image_quotation', 255)->nullable()->charset('utf8');
            $table->string('ecode', 100)->charset('utf8');

            $table->string('create_by', 100)->charset('utf8')->nullable();
            $table->string('update_by', 100)->charset('utf8')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_timelines');
    }
}
