<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
public function up() {
Schema::create('students', function (Blueprint $table) {
$table->id();
$table->string('student_id')->unique(); // unique human-friendly id
$table->string('first_name');
$table->string('last_name')->nullable();
$table->string('profile_photo')->nullable();
$table->integer('age')->nullable();
$table->date('dob')->nullable();
$table->string('email')->unique();
$table->string('pincode')->nullable();
$table->string('phone')->nullable();
$table->foreignId('department_id')->constrained()->cascadeOnDelete();
$table->foreignId('country_id')->nullable()->constrained();
$table->foreignId('state_id')->nullable()->constrained();
$table->foreignId('city_id')->nullable()->constrained();

$table->timestamps();
});
}


public function down() {
Schema::dropIfExists('students');
}
};