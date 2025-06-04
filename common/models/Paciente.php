<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "paciente".
 *
 * @property int $id
 * @property string $cedula
 * @property string $nombres
 * @property string $apellidos
 * @property string $fecha_nacimiento
 * @property string $sexo
 * @property string $direccion
 * @property string|null $telefono
 * @property string|null $estado_civil
 * @property string|null $ocupacion
 * @property string|null $empresa
 * @property string|null $aseguradora
 * @property string|null $grupo_sanguineo
 * @property string|null $nacionalidad
 * @property string|null $nivel_instruccion
 * @property string|null $contacto_emergencia_nombre
 * @property string|null $contacto_emergencia_telefono
 * @property string|null $estado
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 *
 * @property HistoriasClinicas[] $historiasClinicas
 */
class Paciente extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const SEXO_M = 'M';
    const SEXO_F = 'F';
    const ESTADO_CIVIL_SOLTERO = 'soltero';
    const ESTADO_CIVIL_CASADO = 'casado';
    const ESTADO_CIVIL_VIUDO = 'viudo';
    const ESTADO_CIVIL_DIVORCIADO = 'divorciado';
    const ESTADO_CIVIL_UNION_LIBRE = 'union libre';
    const ESTADO_ACTIVO = 'activo';
    const ESTADO_INACTIVO = 'inactivo';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paciente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefono', 'ocupacion', 'empresa', 'aseguradora', 'grupo_sanguineo', 'nacionalidad', 'nivel_instruccion', 'contacto_emergencia_nombre', 'contacto_emergencia_telefono'], 'default', 'value' => null],
            [['estado_civil'], 'default', 'value' => 'soltero'],
            [['estado'], 'default', 'value' => 'activo'],
            [['cedula', 'nombres', 'apellidos', 'fecha_nacimiento', 'sexo', 'direccion', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'required'],
            [['fecha_nacimiento'], 'safe'],
            [['sexo', 'estado_civil', 'estado'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['cedula'], 'string', 'max' => 20],
            [['nombres', 'apellidos', 'ocupacion', 'empresa', 'aseguradora', 'contacto_emergencia_nombre'], 'string', 'max' => 100],
            [['direccion'], 'string', 'max' => 255],
            [['telefono', 'nacionalidad', 'nivel_instruccion', 'contacto_emergencia_telefono'], 'string', 'max' => 50],
            [['grupo_sanguineo'], 'string', 'max' => 3],
            ['sexo', 'in', 'range' => array_keys(self::optsSexo())],
            ['estado_civil', 'in', 'range' => array_keys(self::optsEstadoCivil())],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['cedula'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cedula' => 'Cedula',
            'nombres' => 'Nombres',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'sexo' => 'Sexo',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'estado_civil' => 'Estado Civil',
            'ocupacion' => 'Ocupacion',
            'empresa' => 'Empresa',
            'aseguradora' => 'Aseguradora',
            'grupo_sanguineo' => 'Grupo Sanguineo',
            'nacionalidad' => 'Nacionalidad',
            'nivel_instruccion' => 'Nivel Instruccion',
            'contacto_emergencia_nombre' => 'Contacto Emergencia Nombre',
            'contacto_emergencia_telefono' => 'Contacto Emergencia Telefono',
            'estado' => 'Estado',
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
        return $this->hasMany(HistoriasClinicas::class, ['paciente_id' => 'id']);
    }


    /**
     * column sexo ENUM value labels
     * @return string[]
     */
    public static function optsSexo()
    {
        return [
            self::SEXO_M => 'M',
            self::SEXO_F => 'F',
        ];
    }

    /**
     * column estado_civil ENUM value labels
     * @return string[]
     */
    public static function optsEstadoCivil()
    {
        return [
            self::ESTADO_CIVIL_SOLTERO => 'soltero',
            self::ESTADO_CIVIL_CASADO => 'casado',
            self::ESTADO_CIVIL_VIUDO => 'viudo',
            self::ESTADO_CIVIL_DIVORCIADO => 'divorciado',
            self::ESTADO_CIVIL_UNION_LIBRE => 'union libre',
        ];
    }

    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_ACTIVO => 'activo',
            self::ESTADO_INACTIVO => 'inactivo',
        ];
    }

    /**
     * @return string
     */
    public function displaySexo()
    {
        return self::optsSexo()[$this->sexo];
    }

    /**
     * @return bool
     */
    public function isSexoM()
    {
        return $this->sexo === self::SEXO_M;
    }

    public function setSexoToM()
    {
        $this->sexo = self::SEXO_M;
    }

    /**
     * @return bool
     */
    public function isSexoF()
    {
        return $this->sexo === self::SEXO_F;
    }

    public function setSexoToF()
    {
        $this->sexo = self::SEXO_F;
    }

    /**
     * @return string
     */
    public function displayEstadoCivil()
    {
        return self::optsEstadoCivil()[$this->estado_civil];
    }

    /**
     * @return bool
     */
    public function isEstadoCivilSoltero()
    {
        return $this->estado_civil === self::ESTADO_CIVIL_SOLTERO;
    }

    public function setEstadoCivilToSoltero()
    {
        $this->estado_civil = self::ESTADO_CIVIL_SOLTERO;
    }

    /**
     * @return bool
     */
    public function isEstadoCivilCasado()
    {
        return $this->estado_civil === self::ESTADO_CIVIL_CASADO;
    }

    public function setEstadoCivilToCasado()
    {
        $this->estado_civil = self::ESTADO_CIVIL_CASADO;
    }

    /**
     * @return bool
     */
    public function isEstadoCivilViudo()
    {
        return $this->estado_civil === self::ESTADO_CIVIL_VIUDO;
    }

    public function setEstadoCivilToViudo()
    {
        $this->estado_civil = self::ESTADO_CIVIL_VIUDO;
    }

    /**
     * @return bool
     */
    public function isEstadoCivilDivorciado()
    {
        return $this->estado_civil === self::ESTADO_CIVIL_DIVORCIADO;
    }

    public function setEstadoCivilToDivorciado()
    {
        $this->estado_civil = self::ESTADO_CIVIL_DIVORCIADO;
    }

    /**
     * @return bool
     */
    public function isEstadoCivilUnionLibre()
    {
        return $this->estado_civil === self::ESTADO_CIVIL_UNION_LIBRE;
    }

    public function setEstadoCivilToUnionLibre()
    {
        $this->estado_civil = self::ESTADO_CIVIL_UNION_LIBRE;
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
    public function isEstadoInactivo()
    {
        return $this->estado === self::ESTADO_INACTIVO;
    }

    public function setEstadoToInactivo()
    {
        $this->estado = self::ESTADO_INACTIVO;
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
