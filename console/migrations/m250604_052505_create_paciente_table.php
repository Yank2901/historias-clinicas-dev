<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%paciente}}`.
 */
class m250604_052505_create_paciente_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%paciente}}', [
            'id' => $this->primaryKey(),
            'cedula' => $this->string(20)->notNull()->unique(),
            'nombres' => $this->string(100)->notNull(),
            'apellidos' => $this->string(100)->notNull(),
            'fecha_nacimiento' => $this->date()->notNull(),
            'sexo' => "ENUM('M','F') NOT NULL",
            'direccion' => $this->string(255)->notNull(),
            'telefono' => $this->string(50),
            'estado_civil' => "ENUM('soltero','casado','viudo','divorciado','union libre') DEFAULT 'soltero'",
            'ocupacion' => $this->string(100),
            'empresa' => $this->string(100),
            'aseguradora' => $this->string(100),
            'grupo_sanguineo' => $this->string(3),
            'nacionalidad' => $this->string(50),
            'nivel_instruccion' => $this->string(50),
            'contacto_emergencia_nombre' => $this->string(100),
            'contacto_emergencia_telefono' => $this->string(50),
            'estado' => "ENUM('activo','inactivo') DEFAULT 'activo'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx_paciente_cedula', '{{%paciente}}', 'cedula');
        $this->createIndex('idx_paciente_nombres', '{{%paciente}}', 'nombres');
        $this->createIndex('idx_paciente_apellidos', '{{%paciente}}', 'apellidos');
        $this->createIndex('idx_paciente_estado', '{{%paciente}}', 'estado');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%paciente}}');
    }
}
