<?php

namespace Database\Seeders\Catalogs;

use App\Enums\OecdLevel;
use Illuminate\Database\Seeder;
use App\Models\Catalogs\OecdSector;

class OecdSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nota: los campos "code" solo se usan para mapear la jerarquía (no se guardan en BD).
        $areas = [
            ['code' => 1, 'name' => 'Ciencias naturales'],
            ['code' => 2, 'name' => 'Ingeniería y tecnología'],
            ['code' => 3, 'name' => 'Ciencias médicas y de la salud'],
            ['code' => 4, 'name' => 'Ciencias agrícolas y veterinarias'],
            ['code' => 5, 'name' => 'Ciencias sociales'],
            ['code' => 6, 'name' => 'Humanidades y artes'],
        ];

        $subareas = [
            ['code' => '1.1', 'area_code' => 1, 'name' => 'Matemáticas'],
            ['code' => '1.2', 'area_code' => 1, 'name' => 'Ciencias de la computación e información'],
            ['code' => '1.3', 'area_code' => 1, 'name' => 'Ciencias físicas'],
            ['code' => '1.4', 'area_code' => 1, 'name' => 'Ciencias químicas'],
            ['code' => '1.5', 'area_code' => 1, 'name' => 'Ciencias de la Tierra y medioambientales'],
            ['code' => '1.6', 'area_code' => 1, 'name' => 'Ciencias biológicas'],

            ['code' => '2.1', 'area_code' => 2, 'name' => 'Ingeniería civil'],
            ['code' => '2.2', 'area_code' => 2, 'name' => 'Ingeniería eléctrica, electrónica e informática'],
            ['code' => '2.3', 'area_code' => 2, 'name' => 'Ingeniería mecánica'],
            ['code' => '2.4', 'area_code' => 2, 'name' => 'Ingeniería química'],
            ['code' => '2.5', 'area_code' => 2, 'name' => 'Ingeniería de materiales'],
            ['code' => '2.6', 'area_code' => 2, 'name' => 'Ingeniería médica'],
            ['code' => '2.7', 'area_code' => 2, 'name' => 'Ingeniería ambiental'],
            ['code' => '2.8', 'area_code' => 2, 'name' => 'Biotecnología ambiental y médica'],
            ['code' => '2.9', 'area_code' => 2, 'name' => 'Nanotecnología'],
            ['code' => '2.10', 'area_code' => 2, 'name' => 'Otras ingenierías y tecnologías'],

            ['code' => '3.1', 'area_code' => 3, 'name' => 'Medicina básica'],
            ['code' => '3.2', 'area_code' => 3, 'name' => 'Medicina clínica'],
            ['code' => '3.3', 'area_code' => 3, 'name' => 'Ciencias de la salud'],
            ['code' => '3.4', 'area_code' => 3, 'name' => 'Biotecnología médica'],

            ['code' => '4.1', 'area_code' => 4, 'name' => 'Agricultura, silvicultura y pesca'],
            ['code' => '4.2', 'area_code' => 4, 'name' => 'Ciencia animal y veterinaria'],
            ['code' => '4.3', 'area_code' => 4, 'name' => 'Biotecnología agrícola'],

            ['code' => '5.1', 'area_code' => 5, 'name' => 'Psicología'],
            ['code' => '5.2', 'area_code' => 5, 'name' => 'Economía y negocios'],
            ['code' => '5.3', 'area_code' => 5, 'name' => 'Ciencias de la educación'],
            ['code' => '5.4', 'area_code' => 5, 'name' => 'Sociología'],
            ['code' => '5.5', 'area_code' => 5, 'name' => 'Derecho'],
            ['code' => '5.6', 'area_code' => 5, 'name' => 'Ciencias políticas'],
            ['code' => '5.7', 'area_code' => 5, 'name' => 'Geografía social y económica'],
            ['code' => '5.8', 'area_code' => 5, 'name' => 'Medios de comunicación y comunicaciones'],
            ['code' => '5.9', 'area_code' => 5, 'name' => 'Otras ciencias sociales'],

            ['code' => '6.1', 'area_code' => 6, 'name' => 'Historia y arqueología'],
            ['code' => '6.2', 'area_code' => 6, 'name' => 'Lenguas y literatura'],
            ['code' => '6.3', 'area_code' => 6, 'name' => 'Filosofía, ética y religión'],
            ['code' => '6.4', 'area_code' => 6, 'name' => 'Artes'],
            ['code' => '6.5', 'area_code' => 6, 'name' => 'Otras humanidades'],
        ];

        $disciplinas = [
            ['code' => '1.1.1', 'subarea_code' => '1.1', 'name' => 'Matemáticas puras'],
            ['code' => '1.1.2', 'subarea_code' => '1.1', 'name' => 'Álgebra y teoría de números'],
            ['code' => '1.1.3', 'subarea_code' => '1.1', 'name' => 'Análisis matemático'],
            ['code' => '1.1.4', 'subarea_code' => '1.1', 'name' => 'Geometría y topología'],
            ['code' => '1.1.5', 'subarea_code' => '1.1', 'name' => 'Matemáticas aplicadas'],
            ['code' => '1.1.6', 'subarea_code' => '1.1', 'name' => 'Probabilidad y estadística'],

            ['code' => '1.2.1', 'subarea_code' => '1.2', 'name' => 'Ciencias de la computación, inteligencia artificial y bioinformática'],
            ['code' => '1.2.2', 'subarea_code' => '1.2', 'name' => 'Arquitectura y organización de computadores'],
            ['code' => '1.2.3', 'subarea_code' => '1.2', 'name' => 'Ingeniería de software y sistemas de información'],
            ['code' => '1.2.4', 'subarea_code' => '1.2', 'name' => 'Ciencia de datos y bases de datos'],
            ['code' => '1.2.5', 'subarea_code' => '1.2', 'name' => 'Interacción humano-computadora y multimedia'],
            ['code' => '1.2.6', 'subarea_code' => '1.2', 'name' => 'Ciberseguridad y criptografía'],

            ['code' => '1.3.1', 'subarea_code' => '1.3', 'name' => 'Física atómica, molecular y química'],
            ['code' => '1.3.2', 'subarea_code' => '1.3', 'name' => 'Física de partículas y campos'],
            ['code' => '1.3.3', 'subarea_code' => '1.3', 'name' => 'Física nuclear'],
            ['code' => '1.3.4', 'subarea_code' => '1.3', 'name' => 'Física de la materia condensada'],
            ['code' => '1.3.5', 'subarea_code' => '1.3', 'name' => 'Óptica'],
            ['code' => '1.3.6', 'subarea_code' => '1.3', 'name' => 'Acústica'],
            ['code' => '1.3.7', 'subarea_code' => '1.3', 'name' => 'Astronomía y astrofísica'],
            ['code' => '1.3.8', 'subarea_code' => '1.3', 'name' => 'Física aplicada'],

            ['code' => '1.4.1', 'subarea_code' => '1.4', 'name' => 'Química orgánica'],
            ['code' => '1.4.2', 'subarea_code' => '1.4', 'name' => 'Química inorgánica y nuclear'],
            ['code' => '1.4.3', 'subarea_code' => '1.4', 'name' => 'Química física'],
            ['code' => '1.4.4', 'subarea_code' => '1.4', 'name' => 'Química analítica'],
            ['code' => '1.4.5', 'subarea_code' => '1.4', 'name' => 'Bioquímica'],
            ['code' => '1.4.6', 'subarea_code' => '1.4', 'name' => 'Ciencia de los polímeros'],
            ['code' => '1.4.7', 'subarea_code' => '1.4', 'name' => 'Química aplicada'],

            ['code' => '1.5.1', 'subarea_code' => '1.5', 'name' => 'Geociencias'],
            ['code' => '1.5.2', 'subarea_code' => '1.5', 'name' => 'Geoquímica y geofísica'],
            ['code' => '1.5.3', 'subarea_code' => '1.5', 'name' => 'Meteorología y ciencias atmosféricas'],
            ['code' => '1.5.4', 'subarea_code' => '1.5', 'name' => 'Oceanografía, hidrología y recursos hídricos'],
            ['code' => '1.5.5', 'subarea_code' => '1.5', 'name' => 'Ecología y medio ambiente'],

            ['code' => '1.6.1', 'subarea_code' => '1.6', 'name' => 'Biología celular y microbiología'],
            ['code' => '1.6.2', 'subarea_code' => '1.6', 'name' => 'Genética y herencia'],
            ['code' => '1.6.3', 'subarea_code' => '1.6', 'name' => 'Biología del desarrollo'],
            ['code' => '1.6.4', 'subarea_code' => '1.6', 'name' => 'Biología molecular'],
            ['code' => '1.6.5', 'subarea_code' => '1.6', 'name' => 'Biofísica'],
            ['code' => '1.6.6', 'subarea_code' => '1.6', 'name' => 'Neurociencias'],
            ['code' => '1.6.7', 'subarea_code' => '1.6', 'name' => 'Zoología, ornitología, entomología'],
            ['code' => '1.6.8', 'subarea_code' => '1.6', 'name' => 'Botánica'],
            ['code' => '1.6.9', 'subarea_code' => '1.6', 'name' => 'Ecología, evolución, ciencias del comportamiento'],
            ['code' => '1.6.10', 'subarea_code' => '1.6', 'name' => 'Biología marina, de agua dulce y limnología'],
            ['code' => '1.6.11', 'subarea_code' => '1.6', 'name' => 'Biodiversidad'],
            ['code' => '1.6.12', 'subarea_code' => '1.6', 'name' => 'Biología teórica y modelización'],
            ['code' => '1.6.13', 'subarea_code' => '1.6', 'name' => 'Otras ciencias biológicas'],

            ['code' => '2.1.1', 'subarea_code' => '2.1', 'name' => 'Ingeniería de la construcción'],
            ['code' => '2.1.2', 'subarea_code' => '2.1', 'name' => 'Ingeniería estructural'],
            ['code' => '2.1.3', 'subarea_code' => '2.1', 'name' => 'Ingeniería del transporte'],
            ['code' => '2.1.4', 'subarea_code' => '2.1', 'name' => 'Ingeniería municipal y de aguas residuales'],
            ['code' => '2.1.5', 'subarea_code' => '2.1', 'name' => 'Ingeniería geotécnica'],
            ['code' => '2.1.6', 'subarea_code' => '2.1', 'name' => 'Ingeniería oceánica'],
            ['code' => '2.1.7', 'subarea_code' => '2.1', 'name' => 'Otras ingenierías civiles'],

            ['code' => '2.2.1', 'subarea_code' => '2.2', 'name' => 'Ingeniería eléctrica y electrónica'],
            ['code' => '2.2.2', 'subarea_code' => '2.2', 'name' => 'Robótica y control automático'],
            ['code' => '2.2.3', 'subarea_code' => '2.2', 'name' => 'Ingeniería de telecomunicaciones'],
            ['code' => '2.2.4', 'subarea_code' => '2.2', 'name' => 'Hardware y arquitectura de computadores'],
            ['code' => '2.2.5', 'subarea_code' => '2.2', 'name' => 'Redes y sistemas de comunicación'],
            ['code' => '2.2.6', 'subarea_code' => '2.2', 'name' => 'Instrumentación e ingeniería de medición'],
            ['code' => '2.2.7', 'subarea_code' => '2.2', 'name' => 'Otras ingenierías eléctricas, electrónicas e informáticas'],

            ['code' => '2.3.1', 'subarea_code' => '2.3', 'name' => 'Ingeniería mecánica'],
            ['code' => '2.3.2', 'subarea_code' => '2.3', 'name' => 'Mecánica aplicada'],
            ['code' => '2.3.3', 'subarea_code' => '2.3', 'name' => 'Ingeniería aeroespacial'],
            ['code' => '2.3.4', 'subarea_code' => '2.3', 'name' => 'Ingeniería marítima'],
            ['code' => '2.3.5', 'subarea_code' => '2.3', 'name' => 'Ingeniería de fabricación'],
            ['code' => '2.3.6', 'subarea_code' => '2.3', 'name' => 'Ingeniería de sistemas'],
            ['code' => '2.3.7', 'subarea_code' => '2.3', 'name' => 'Termodinámica'],
            ['code' => '2.3.8', 'subarea_code' => '2.3', 'name' => 'Ingeniería de materiales mecánicos'],
            ['code' => '2.3.9', 'subarea_code' => '2.3', 'name' => 'Otras ingenierías mecánicas'],

            ['code' => '2.4.1', 'subarea_code' => '2.4', 'name' => 'Ingeniería química'],
            ['code' => '2.4.2', 'subarea_code' => '2.4', 'name' => 'Ingeniería de procesos'],
            ['code' => '2.4.3', 'subarea_code' => '2.4', 'name' => 'Ingeniería de reactores'],
            ['code' => '2.4.4', 'subarea_code' => '2.4', 'name' => 'Ingeniería petroquímica'],
            ['code' => '2.4.5', 'subarea_code' => '2.4', 'name' => 'Separación y purificación'],
            ['code' => '2.4.6', 'subarea_code' => '2.4', 'name' => 'Otras ingenierías químicas'],

            ['code' => '2.5.1', 'subarea_code' => '2.5', 'name' => 'Ciencia e ingeniería de materiales'],
            ['code' => '2.5.2', 'subarea_code' => '2.5', 'name' => 'Cerámicas'],
            ['code' => '2.5.3', 'subarea_code' => '2.5', 'name' => 'Recubrimientos y películas'],
            ['code' => '2.5.4', 'subarea_code' => '2.5', 'name' => 'Compuestos'],
            ['code' => '2.5.5', 'subarea_code' => '2.5', 'name' => 'Papel y madera'],
            ['code' => '2.5.6', 'subarea_code' => '2.5', 'name' => 'Textiles'],
            ['code' => '2.5.7', 'subarea_code' => '2.5', 'name' => 'Otros materiales'],

            ['code' => '2.6.1', 'subarea_code' => '2.6', 'name' => 'Ingeniería biomédica'],
            ['code' => '2.6.2', 'subarea_code' => '2.6', 'name' => 'Tecnologías médicas'],
            ['code' => '2.6.3', 'subarea_code' => '2.6', 'name' => 'Ingeniería clínica'],
            ['code' => '2.6.4', 'subarea_code' => '2.6', 'name' => 'Otras ingenierías médicas'],

            ['code' => '2.7.1', 'subarea_code' => '2.7', 'name' => 'Ingeniería ambiental'],
            ['code' => '2.7.2', 'subarea_code' => '2.7', 'name' => 'Saneamiento'],
            ['code' => '2.7.3', 'subarea_code' => '2.7', 'name' => 'Gestión de residuos'],
            ['code' => '2.7.4', 'subarea_code' => '2.7', 'name' => 'Tecnologías limpias'],
            ['code' => '2.7.5', 'subarea_code' => '2.7', 'name' => 'Otras ingenierías ambientales'],

            ['code' => '2.8.1', 'subarea_code' => '2.8', 'name' => 'Biotecnología ambiental'],
            ['code' => '2.8.2', 'subarea_code' => '2.8', 'name' => 'Biotecnología médica'],
            ['code' => '2.8.3', 'subarea_code' => '2.8', 'name' => 'Bioingeniería'],
            ['code' => '2.8.4', 'subarea_code' => '2.8', 'name' => 'Otras biotecnologías'],

            ['code' => '2.9.1', 'subarea_code' => '2.9', 'name' => 'Nanociencia'],
            ['code' => '2.9.2', 'subarea_code' => '2.9', 'name' => 'Nanomateriales'],
            ['code' => '2.9.3', 'subarea_code' => '2.9', 'name' => 'Nanoelectrónica'],
            ['code' => '2.9.4', 'subarea_code' => '2.9', 'name' => 'Nanotecnología aplicada'],
            ['code' => '2.9.5', 'subarea_code' => '2.9', 'name' => 'Otras nanotecnologías'],

            ['code' => '2.10.1', 'subarea_code' => '2.10', 'name' => 'Ingeniería industrial'],
            ['code' => '2.10.2', 'subarea_code' => '2.10', 'name' => 'Ingeniería de alimentos'],
            ['code' => '2.10.3', 'subarea_code' => '2.10', 'name' => 'Ingeniería minera'],
            ['code' => '2.10.4', 'subarea_code' => '2.10', 'name' => 'Ingeniería energética'],
            ['code' => '2.10.5', 'subarea_code' => '2.10', 'name' => 'Otras ingenierías y tecnologías'],

            ['code' => '3.1.1', 'subarea_code' => '3.1', 'name' => 'Anatomía y morfología'],
            ['code' => '3.1.2', 'subarea_code' => '3.1', 'name' => 'Genética humana'],
            ['code' => '3.1.3', 'subarea_code' => '3.1', 'name' => 'Inmunología'],
            ['code' => '3.1.4', 'subarea_code' => '3.1', 'name' => 'Neurociencias (incluye psicofisiología)'],
            ['code' => '3.1.5', 'subarea_code' => '3.1', 'name' => 'Farmacología y farmacia'],
            ['code' => '3.1.6', 'subarea_code' => '3.1', 'name' => 'Toxicología'],
            ['code' => '3.1.7', 'subarea_code' => '3.1', 'name' => 'Fisiología'],
            ['code' => '3.1.8', 'subarea_code' => '3.1', 'name' => 'Patología'],
            ['code' => '3.1.9', 'subarea_code' => '3.1', 'name' => 'Medicina forense'],
            ['code' => '3.1.10', 'subarea_code' => '3.1', 'name' => 'Otras ciencias básicas de la medicina'],

            ['code' => '3.2.1', 'subarea_code' => '3.2', 'name' => 'Medicina general e interna'],
            ['code' => '3.2.2', 'subarea_code' => '3.2', 'name' => 'Cirugía'],
            ['code' => '3.2.3', 'subarea_code' => '3.2', 'name' => 'Obstetricia y ginecología'],
            ['code' => '3.2.4', 'subarea_code' => '3.2', 'name' => 'Pediatría'],
            ['code' => '3.2.5', 'subarea_code' => '3.2', 'name' => 'Cardiología y sistema cardiovascular'],
            ['code' => '3.2.6', 'subarea_code' => '3.2', 'name' => 'Medicina respiratoria'],
            ['code' => '3.2.7', 'subarea_code' => '3.2', 'name' => 'Medicina crítica y cuidados intensivos'],
            ['code' => '3.2.8', 'subarea_code' => '3.2', 'name' => 'Anestesiología'],
            ['code' => '3.2.9', 'subarea_code' => '3.2', 'name' => 'Radiología, medicina nuclear e imagenología'],
            ['code' => '3.2.10', 'subarea_code' => '3.2', 'name' => 'Trasplantes'],
            ['code' => '3.2.11', 'subarea_code' => '3.2', 'name' => 'Odontología, cirugía oral y medicina oral'],
            ['code' => '3.2.12', 'subarea_code' => '3.2', 'name' => 'Otras medicinas clínicas'],

            ['code' => '3.3.1', 'subarea_code' => '3.3', 'name' => 'Ciencias y servicios de atención sanitaria'],
            ['code' => '3.3.2', 'subarea_code' => '3.3', 'name' => 'Salud pública y ambiental'],
            ['code' => '3.3.3', 'subarea_code' => '3.3', 'name' => 'Nutrición y dietética'],
            ['code' => '3.3.4', 'subarea_code' => '3.3', 'name' => 'Epidemiología'],
            ['code' => '3.3.5', 'subarea_code' => '3.3', 'name' => 'Enfermería'],
            ['code' => '3.3.6', 'subarea_code' => '3.3', 'name' => 'Otras ciencias de la salud'],

            ['code' => '3.4.1', 'subarea_code' => '3.4', 'name' => 'Biotecnología médica'],
            ['code' => '3.4.2', 'subarea_code' => '3.4', 'name' => 'Tecnologías médicas (incluye medicina de laboratorio)'],
            ['code' => '3.4.3', 'subarea_code' => '3.4', 'name' => 'Otras biotecnologías médicas'],

            ['code' => '4.1.1', 'subarea_code' => '4.1', 'name' => 'Agricultura'],
            ['code' => '4.1.2', 'subarea_code' => '4.1', 'name' => 'Silvicultura'],
            ['code' => '4.1.3', 'subarea_code' => '4.1', 'name' => 'Pesca'],
            ['code' => '4.1.4', 'subarea_code' => '4.1', 'name' => 'Ciencia del suelo'],
            ['code' => '4.1.5', 'subarea_code' => '4.1', 'name' => 'Horticultura, viticultura'],
            ['code' => '4.1.6', 'subarea_code' => '4.1', 'name' => 'Agronomía'],
            ['code' => '4.1.7', 'subarea_code' => '4.1', 'name' => 'Otros temas agrícolas'],

            ['code' => '4.2.1', 'subarea_code' => '4.2', 'name' => 'Ciencia animal'],
            ['code' => '4.2.2', 'subarea_code' => '4.2', 'name' => 'Veterinaria'],
            ['code' => '4.2.3', 'subarea_code' => '4.2', 'name' => 'Zootecnia'],
            ['code' => '4.2.4', 'subarea_code' => '4.2', 'name' => 'Otros temas de ciencia animal y veterinaria'],

            ['code' => '4.3.1', 'subarea_code' => '4.3', 'name' => 'Biotecnología agrícola'],
            ['code' => '4.3.2', 'subarea_code' => '4.3', 'name' => 'Biotecnología alimentaria'],
            ['code' => '4.3.3', 'subarea_code' => '4.3', 'name' => 'Otras biotecnologías agrícolas'],

            ['code' => '5.1.1', 'subarea_code' => '5.1', 'name' => 'Psicología'],
            ['code' => '5.1.2', 'subarea_code' => '5.1', 'name' => 'Psicología social'],
            ['code' => '5.1.3', 'subarea_code' => '5.1', 'name' => 'Psicología del desarrollo'],
            ['code' => '5.1.4', 'subarea_code' => '5.1', 'name' => 'Psicología clínica'],
            ['code' => '5.1.5', 'subarea_code' => '5.1', 'name' => 'Psicología cognitiva'],
            ['code' => '5.1.6', 'subarea_code' => '5.1', 'name' => 'Otras psicologías'],

            ['code' => '5.2.1', 'subarea_code' => '5.2', 'name' => 'Economía'],
            ['code' => '5.2.2', 'subarea_code' => '5.2', 'name' => 'Negocios y gestión'],
            ['code' => '5.2.3', 'subarea_code' => '5.2', 'name' => 'Finanzas'],
            ['code' => '5.2.4', 'subarea_code' => '5.2', 'name' => 'Econometría'],
            ['code' => '5.2.5', 'subarea_code' => '5.2', 'name' => 'Otras economías y negocios'],

            ['code' => '5.3.1', 'subarea_code' => '5.3', 'name' => 'Educación general'],
            ['code' => '5.3.2', 'subarea_code' => '5.3', 'name' => 'Didáctica'],
            ['code' => '5.3.3', 'subarea_code' => '5.3', 'name' => 'Evaluación educativa'],
            ['code' => '5.3.4', 'subarea_code' => '5.3', 'name' => 'Educación especial'],
            ['code' => '5.3.5', 'subarea_code' => '5.3', 'name' => 'Otras ciencias de la educación'],

            ['code' => '5.4.1', 'subarea_code' => '5.4', 'name' => 'Sociología'],
            ['code' => '5.4.2', 'subarea_code' => '5.4', 'name' => 'Antropología'],
            ['code' => '5.4.3', 'subarea_code' => '5.4', 'name' => 'Demografía'],
            ['code' => '5.4.4', 'subarea_code' => '5.4', 'name' => 'Estudios de género'],
            ['code' => '5.4.5', 'subarea_code' => '5.4', 'name' => 'Otras sociologías'],

            ['code' => '5.5.1', 'subarea_code' => '5.5', 'name' => 'Derecho'],
            ['code' => '5.5.2', 'subarea_code' => '5.5', 'name' => 'Derecho penal'],
            ['code' => '5.5.3', 'subarea_code' => '5.5', 'name' => 'Derecho civil'],
            ['code' => '5.5.4', 'subarea_code' => '5.5', 'name' => 'Derecho administrativo'],
            ['code' => '5.5.5', 'subarea_code' => '5.5', 'name' => 'Otras ramas del derecho'],

            ['code' => '5.6.1', 'subarea_code' => '5.6', 'name' => 'Ciencias políticas'],
            ['code' => '5.6.2', 'subarea_code' => '5.6', 'name' => 'Administración pública'],
            ['code' => '5.6.3', 'subarea_code' => '5.6', 'name' => 'Relaciones internacionales'],
            ['code' => '5.6.4', 'subarea_code' => '5.6', 'name' => 'Otras ciencias políticas'],

            ['code' => '5.7.1', 'subarea_code' => '5.7', 'name' => 'Geografía humana'],
            ['code' => '5.7.2', 'subarea_code' => '5.7', 'name' => 'Geografía económica'],
            ['code' => '5.7.3', 'subarea_code' => '5.7', 'name' => 'Geografía urbana y regional'],
            ['code' => '5.7.4', 'subarea_code' => '5.7', 'name' => 'Otras geografías sociales y económicas'],

            ['code' => '5.8.1', 'subarea_code' => '5.8', 'name' => 'Medios de comunicación'],
            ['code' => '5.8.2', 'subarea_code' => '5.8', 'name' => 'Comunicación'],
            ['code' => '5.8.3', 'subarea_code' => '5.8', 'name' => 'Periodismo'],
            ['code' => '5.8.4', 'subarea_code' => '5.8', 'name' => 'Otras comunicaciones'],

            ['code' => '5.9.1', 'subarea_code' => '5.9', 'name' => 'Otras ciencias sociales'],

            ['code' => '6.1.1', 'subarea_code' => '6.1', 'name' => 'Historia'],
            ['code' => '6.1.2', 'subarea_code' => '6.1', 'name' => 'Arqueología'],
            ['code' => '6.1.3', 'subarea_code' => '6.1', 'name' => 'Otras historias y arqueologías'],

            ['code' => '6.2.1', 'subarea_code' => '6.2', 'name' => 'Lenguas'],
            ['code' => '6.2.2', 'subarea_code' => '6.2', 'name' => 'Literatura'],
            ['code' => '6.2.3', 'subarea_code' => '6.2', 'name' => 'Lingüística'],
            ['code' => '6.2.4', 'subarea_code' => '6.2', 'name' => 'Otras lenguas y literatura'],

            ['code' => '6.3.1', 'subarea_code' => '6.3', 'name' => 'Filosofía'],
            ['code' => '6.3.2', 'subarea_code' => '6.3', 'name' => 'Ética'],
            ['code' => '6.3.3', 'subarea_code' => '6.3', 'name' => 'Religión'],
            ['code' => '6.3.4', 'subarea_code' => '6.3', 'name' => 'Otras filosofías, éticas y religiones'],

            ['code' => '6.4.1', 'subarea_code' => '6.4', 'name' => 'Artes (historia del arte, artes escénicas, artes visuales)'],
            ['code' => '6.4.2', 'subarea_code' => '6.4', 'name' => 'Diseño'],
            ['code' => '6.4.3', 'subarea_code' => '6.4', 'name' => 'Música'],
            ['code' => '6.4.4', 'subarea_code' => '6.4', 'name' => 'Otras artes'],

            ['code' => '6.5.1', 'subarea_code' => '6.5', 'name' => 'Otras humanidades'],
        ];

        // 1) Áreas (level = 1)
        $areaMap = [];
        foreach ($areas as $item) {
            $record = OecdSector::updateOrCreate(
                [
                    'name' => $item['name'],
                    'parent_id' => null,
                ],
                [
                    'level' => OecdLevel::MAIN_AREA->value,
                    'economic_social_sector_id' => null,
                ]
            );

            $areaMap[$item['code']] = $record->id;
        }

        // 2) Subáreas (level = 2)
        $subareaMap = [];
        foreach ($subareas as $item) {
            $parentId = $areaMap[$item['area_code']] ?? null;

            $record = OecdSector::updateOrCreate(
                [
                    'name' => $item['name'],
                    'parent_id' => $parentId,
                ],
                [
                    'level' => OecdLevel::SUBAREA->value,
                    'economic_social_sector_id' => null,
                ]
            );

            $subareaMap[$item['code']] = $record->id;
        }

        // 3) Disciplinas (level = 3)
        foreach ($disciplinas as $item) {
            $parentId = $subareaMap[$item['subarea_code']] ?? null;

            OecdSector::updateOrCreate(
                [
                    'name' => $item['name'],
                    'parent_id' => $parentId,
                ],
                [
                    'level' => OecdLevel::DISCIPLINE->value,
                    'economic_social_sector_id' => null,
                ]
            );
        }
    }
}
