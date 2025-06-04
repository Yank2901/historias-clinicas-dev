<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $rol
 * @property int|null $doctor_id
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property HistoriasClinicas[] $historiasClinicas
 */
class Usuario extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ROL_ADMIN = 'admin';
    const ROL_DOCTOR = 'doctor';
    const ROL_ASISTENTE = 'asistente';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doctor_id', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['username', 'password_hash', 'rol', 'created_at', 'updated_at'], 'required'],
            [['rol'], 'string'],
            [['doctor_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['username'], 'string', 'max' => 100],
            [['password_hash'], 'string', 'max' => 255],
            ['rol', 'in', 'range' => array_keys(self::optsRol())],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'rol' => 'Rol',
            'doctor_id' => 'Doctor ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[HistoriasClinicas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHistoriasClinicas()
    {
        return $this->hasMany(HistoriasClinicas::class, ['doctor_id' => 'id']);
    }


    /**
     * column rol ENUM value labels
     * @return string[]
     */
    public static function optsRol()
    {
        return [
            self::ROL_ADMIN => 'admin',
            self::ROL_DOCTOR => 'doctor',
            self::ROL_ASISTENTE => 'asistente',
        ];
    }

    /**
     * @return string
     */
    public function displayRol()
    {
        return self::optsRol()[$this->rol];
    }

    /**
     * @return bool
     */
    public function isRolAdmin()
    {
        return $this->rol === self::ROL_ADMIN;
    }

    public function setRolToAdmin()
    {
        $this->rol = self::ROL_ADMIN;
    }

    /**
     * @return bool
     */
    public function isRolDoctor()
    {
        return $this->rol === self::ROL_DOCTOR;
    }

    public function setRolToDoctor()
    {
        $this->rol = self::ROL_DOCTOR;
    }

    /**
     * @return bool
     */
    public function isRolAsistente()
    {
        return $this->rol === self::ROL_ASISTENTE;
    }

    public function setRolToAsistente()
    {
        $this->rol = self::ROL_ASISTENTE;
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
