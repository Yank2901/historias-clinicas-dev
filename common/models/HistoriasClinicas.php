<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "historias_clinicas".
 *
 * @property int $id
 * @property int $paciente_id
 * @property int $doctor_id
 * @property string $fecha
 * @property string|null $contenido
 * @property string|null $estado
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property Usuario $doctor
 * @property Paciente $paciente
 */
class HistoriasClinicas extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_ELIMINADO = 'eliminado';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historias_clinicas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contenido'], 'default', 'value' => null],
            [['estado'], 'default', 'value' => 'activo'],
            [['paciente_id', 'doctor_id', 'fecha', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['paciente_id', 'doctor_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['fecha'], 'safe'],
            [['contenido', 'estado'], 'string'],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['doctor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['doctor_id' => 'id']],
            [['paciente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::class, 'targetAttribute' => ['paciente_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paciente_id' => 'Paciente ID',
            'doctor_id' => 'Doctor ID',
            'fecha' => 'Fecha',
            'contenido' => 'Contenido',
            'estado' => 'Estado',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Doctor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor()
    {
        return $this->hasOne(Usuario::class, ['id' => 'doctor_id']);
    }

    /**
     * Gets query for [[Paciente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::class, ['id' => 'paciente_id']);
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_ACTIVO => 'activo',
            self::ESTADO_ELIMINADO => 'eliminado',
        ];
    }

    /**
     * @return string
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    /**
     * @return bool
     */
    public function isEstadoActivo()
    {
        return $this->estado === self::ESTADO_ACTIVO;
    }

    public function setEstadoToActivo()
    {
        $this->estado = self::ESTADO_ACTIVO;
    }

    /**
     * @return bool
     */
    public function isEstadoEliminado()
    {
        return $this->estado === self::ESTADO_ELIMINADO;
    }

    public function setEstadoToEliminado()
    {
        $this->estado = self::ESTADO_ELIMINADO;
    }
    
    /**
     * Behaviors
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(), // Guarda el timestamp como entero
            ],
        ];
    }
}
