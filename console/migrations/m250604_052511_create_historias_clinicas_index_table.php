<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%historias_clinicas}}`.
 */
class m250604_052511_create_historias_clinicas_index_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%historias_clinicas_index}}', [
            'id' => $this->primaryKey(),
            'paciente_id' => $this->integer()->notNull(),
            'doctor_id' => $this->integer()->notNull(),
            'fecha' => $this->date()->notNull(),
            'version' => $this->integer()->notNull()->defaultValue(1),
            'mongo_id' => $this->string(255)->notNull(),
            'estado' => "ENUM('activo','eliminado') DEFAULT 'activo'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
        ]);

        // Claves foráneas
        $this->addForeignKey(
            'fk_historia_paciente',
            '{{%historias_clinicas_index}}',
            'paciente_id',
            '{{%paciente}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_historia_doctor',
            '{{%historias_clinicas_index}}',
            'doctor_id',
            '{{%usuario}}',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        // Índices
        $this->createIndex('idx_historia_paciente_id', '{{%historias_clinicas_index}}', 'paciente_id');
        $this->createIndex('idx_historia_doctor_id', '{{%historias_clinicas_index}}', 'doctor_id');
        $this->createIndex('idx_historia_estado', '{{%historias_clinicas_index}}', 'estado');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_historia_paciente', '{{%historias_clinicas_index}}');
        $this->dropForeignKey('fk_historia_doctor', '{{%historias_clinicas_index}}');
        $this->dropTable('{{%historias_clinicas_index}}');
    }
}
