<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploiDuTempsTable extends Migration
{
    public function up()
    {
        Schema::create('emploi_du_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes');
            $table->foreignId('cours_id')->constrained('cours');
            $table->foreignId('professeur_id')->constrained('professeurs');
            $table->enum('jour', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('salle');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emploi_du_temps');
    }
}

