<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%historias_clinicas}}`.
 */
class m250604_052511_create_historias_clinicas_tableyes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%historias_clinicas}}', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'fecha' => $this->date()->notNull(),
            'contenido' => $this->text(),
            'estado' => "ENUM('activo','eliminado') DEFAULT 'activo'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        // Claves foráneas
        $this->addForeignKey(
            'fk_historias_paciente',
            '{{%historias_clinicas}}',
            'paciente_id',
            '{{%paciente}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_historias_doctor',
            '{{%historias_clinicas}}',
            'doctor_id',
            '{{%usuario}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        // Índices
        $this->createIndex('idx_historia_paciente_id', '{{%historias_clinicas}}', 'paciente_id');
        $this->createIndex('idx_historia_doctor_id', '{{%historias_clinicas}}', 'doctor_id');
        $this->createIndex('idx_historia_estado', '{{%historias_clinicas}}', 'estado');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_historias_paciente', '{{%historias_clinicas}}');
        $this->dropForeignKey('fk_historias_doctor', '{{%historias_clinicas}}');
        $this->dropTable('{{%historias_clinicas}}');
    }
}
