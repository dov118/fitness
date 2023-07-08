<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\File;
use App\Models\Muscle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/ecartes-incline-avec-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/ecartes-incline-avec-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [13, 14])->get())->create([
            'name' => 'Écartés incliné aux haltères',
            'guideline' => 'Prise sérrée / préférer haltère / incliné
Coudes assez proches du torse
Poignet a hauteur de pec
Ne pas bouger les coudes, remonté à fond, 90°',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 4,
        ]);
        Muscle::find(13)->setIntensity($exercise->id, 1);
        Muscle::find(14)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/developpe-decline-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/developpe-decline-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [13, 14])->get())->create([
            'name' => 'Développé décliné aux haltères',
            'guideline' => 'Limiter les mouement au niveau des coude
Coude à 70° plus proche de 90°',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 3.68,
        ]);
        Muscle::find(13)->setIntensity($exercise->id, 0.5);
        Muscle::find(14)->setIntensity($exercise->id, 1);


        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/developpe-militaire.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/developpe-militaire.gif'))]))->hasAttached(Muscle::whereIn('id', [6, 7])->get())->create([
            'name' => 'Développé militaire',
            'guideline' => '',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 15,
            'light_max' => 20,
            'duration' => 2.24,
        ]);
        Muscle::find(6)->setIntensity($exercise->id, 1);
        Muscle::find(7)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/elevations-laterales.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/elevations-laterales.gif'))]))->hasAttached(Muscle::whereIn('id', [6, 7, 8])->get())->create([
            'name' => 'Élévations latérales unilateral',
            'guideline' => 'tirer omoplate et clavicule en arriere',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 15,
            'light_max' => 20,
            'duration' => 4.04,
        ]);
        Muscle::find(6)->setIntensity($exercise->id, 0.5);
        Muscle::find(7)->setIntensity($exercise->id, 1);
        Muscle::find(8)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/dips-sur-une-chaise.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/dips-sur-une-chaise.gif'))]))->hasAttached(Muscle::whereIn('id', [20, 21, 22])->get())->create([
            'name' => 'Dips',
            'guideline' => 'Coude décollé
Genoux pas plié
Poignet neutre (au lieu de pronation pour la douleur)',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 1.91,
        ]);
        Muscle::find(20)->setIntensity($exercise->id, 1);
        Muscle::find(21)->setIntensity($exercise->id, 0.5);
        Muscle::find(22)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/extension-triceps-verticale-elastique.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/extension-triceps-verticale-elastique.gif'))]))->hasAttached(Muscle::whereIn('id', [20, 21, 22])->get())->create([
            'name' => 'Poulis',
            'guideline' => 'Coudes pointent vers les hanches
Coudes sérré + bras vers l\'avant',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 2.8,
        ]);
        Muscle::find(20)->setIntensity($exercise->id, 1);
        Muscle::find(21)->setIntensity($exercise->id, 0.25);
        Muscle::find(22)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/tirage-vertical-prise-serree.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/tirage-vertical-prise-serree.gif'))]))->hasAttached(Muscle::whereIn('id', [15, 16])->get())->create([
            'name' => 'Tirrage vertical à l\'elastique',
            'guideline' => 'omoplates fixes
Coude le plus collé au torse
prise supination',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 12,
            'light_max' => 15,
            'duration' => 2.6,
        ]);
        Muscle::find(15)->setIntensity($exercise->id, 1);
        Muscle::find(16)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/rowing-barre.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/rowing-barre.gif'))]))->hasAttached(Muscle::whereIn('id', [15, 16])->get())->create([
            'name' => 'Rowing barre',
            'guideline' => 'main milieu + tendre bras vers bas droit niveau genoux + juste remonter le tout sur le même axe',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 12,
            'light_max' => 15,
            'duration' => 3.31,
        ]);
        Muscle::find(15)->setIntensity($exercise->id, 0.5);
        Muscle::find(16)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/face-pull.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/face-pull.gif'))]))->hasAttached(Muscle::whereIn('id', [7, 8])->get())->create([
            'name' => 'Face-pulls à l\'élastique',
            'guideline' => 'Ecarter et reculler les poinget vers l\'arrier
 légère pause en contraction ',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 15,
            'light_max' => 20,
            'duration' => 3.09,
        ]);
        Muscle::find(7)->setIntensity($exercise->id, 0.5);
        Muscle::find(8)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/test.jpg', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/test.jpg'))]))->hasAttached(Muscle::whereIn('id', [18, 19, 20])->get())->create([
            'name' => 'Curl marteau croisé',
            'guideline' => 'Prise neutre  + Coude fixe un peu devant diagonal vers mieux de pecs
Monter poignet bien parallel au torce + monter jusqu\'en haut',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 6.1,
        ]);
        Muscle::find(18)->setIntensity($exercise->id, 1);
        Muscle::find(19)->setIntensity($exercise->id, 0.25);
        Muscle::find(20)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/curl-barre.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/curl-barre.gif'))]))->hasAttached(Muscle::whereIn('id', [18, 19, 20])->get())->create([
            'name' => 'Curl à la barre avec une prise large',
            'guideline' => 'Supination ou neutre - Coude légèrement exterieur epaules + Coude proche torce',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 3.74,
        ]);
        Muscle::find(18)->setIntensity($exercise->id, 0.25);
        Muscle::find(19)->setIntensity($exercise->id, 1);
        Muscle::find(20)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/drag-curl-halteres-assis.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/drag-curl-halteres-assis.gif'))]))->hasAttached(Muscle::whereIn('id', [18, 19, 20])->get())->create([
            'name' => 'Drag curl',
            'guideline' => 'Coude avance sensiblement avant - reculer montant - Prise sérrée / tres large',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 5.19,
        ]);
        Muscle::find(18)->setIntensity($exercise->id, 0.25);
        Muscle::find(19)->setIntensity($exercise->id, 0.25);
        Muscle::find(20)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/squat-bulgare-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/squat-bulgare-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [1, 3])->get())->create([
            'name' => 'Fentes bulgares',
            'guideline' => 'Bien plier les jambes
Dos droit + abdo contracté
Genoux pas de gauche droite',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 10,
            'light_max' => 12,
            'duration' => 4.61,
        ]);
        Muscle::find(1)->setIntensity($exercise->id, 1);
        Muscle::find(3)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/souleve-de-terre-jambes-tendues.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/souleve-de-terre-jambes-tendues.gif'))]))->hasAttached(Muscle::whereIn('id', [1, 2, 3])->get())->create([
            'name' => 'Soulevé de terre jambe tendue',
            'guideline' => 'Ne pas bouger les jenoux - garder les jambes proches - Dessendre sans flexion du dos',
            'heavy_min' => 8,
            'heavy_max' => 10,
            'light_min' => 12,
            'light_max' => 15,
            'duration' => 3.12,
        ]);
        Muscle::find(1)->setIntensity($exercise->id, 0.5);
        Muscle::find(2)->setIntensity($exercise->id, 1);
        Muscle::find(3)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/extension-mollets-assis-machine.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/extension-mollets-assis-machine.gif'))]))->hasAttached(Muscle::whereIn('id', [4, 5])->get())->create([
            'name' => 'Extension Mollets Barre Assis',
            'guideline' => 'Ne pas rebondir en bas du mouvement',
            'heavy_min' => 15,
            'heavy_max' => 20,
            'light_min' => 20,
            'light_max' => 25,
            'duration' => 2.77,
        ]);
        Muscle::find(4)->setIntensity($exercise->id, 0.25);
        Muscle::find(5)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/extension-mollets-sur-marche.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/extension-mollets-sur-marche.gif'))]))->hasAttached(Muscle::whereIn('id', [4, 5])->get())->create([
            'name' => 'Debout au bord d’un step unilaterale',
            'guideline' => 'Ne pas rebondir en bas du mouvement
Ne plus changer le poid de coté',
            'heavy_min' => 8,
            'heavy_max' => 10,
            'light_min' => 12,
            'light_max' => 15,
            'duration' => 6.08,
        ]);
        Muscle::find(4)->setIntensity($exercise->id, 1);
        Muscle::find(5)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/exercice-abdos-bicyclette.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/exercice-abdos-bicyclette.gif'))]))->hasAttached(Muscle::whereIn('id', [9, 10, 11, 12])->get())->create([
            'name' => 'Crunch bicyclette',
            'guideline' => 'Inclinaison et tourner le torse
Contracter volontairement les muscles',
            'heavy_min' => 0,
            'heavy_max' => 0,
            'light_min' => 12,
            'light_max' => 15,
            'duration' => 3.44,
        ]);
        Muscle::find(9)->setIntensity($exercise->id, 1);
        Muscle::find(10)->setIntensity($exercise->id, 1);
        Muscle::find(11)->setIntensity($exercise->id, 0.25);
        Muscle::find(12)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/planche-abdos.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/planche-abdos.gif'))]))->hasAttached(Muscle::whereIn('id', [9, 10, 11, 12])->get())->create([
            'name' => 'Gainage',
            'guideline' => 'Renter le ventre ',
            'heavy_min' => 105,
            'heavy_max' => 105,
            'light_min' => 100,
            'light_max' => 100,
            'duration' => 1,
        ]);
        Muscle::find(9)->setIntensity($exercise->id, 0.5);
        Muscle::find(10)->setIntensity($exercise->id, 0.5);
        Muscle::find(11)->setIntensity($exercise->id, 0.5);
        Muscle::find(12)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/developpe-incline-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/developpe-incline-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [13, 14])->get())->create([
            'name' => 'Développé incliné aux haltères',
            'guideline' => 'Prise sérrée
Coudes assez proches du torse
Mettre 4 crans
Garder le coude au même niveau des poignets tout le temps
Bien reculler les omoplate et bomber le torse',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 3.16,
        ]);
        Muscle::find(13)->setIntensity($exercise->id, 1);
        Muscle::find(14)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/ecartes-decline-avec-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/ecartes-decline-avec-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [13, 14])->get())->create([
            'name' => 'Écartés décliné aux haltères',
            'guideline' => 'Limiter les mouement au niveau des coude
Coude niveau nombrile / milieu du torse',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 4.73,
        ]);
        Muscle::find(13)->setIntensity($exercise->id, 0.5);
        Muscle::find(14)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/developpe-epaule-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/developpe-epaule-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [6, 7])->get())->create([
            'name' => 'Développé épaules haltères',
            'guideline' => 'Garder le bras tendue  - Bien monter',
            'heavy_min' => 10,
            'heavy_max' => 12,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 3.12,
        ]);
        Muscle::find(6)->setIntensity($exercise->id, 1);
        Muscle::find(7)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/tirage-menton-machine-guidee.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/tirage-menton-machine-guidee.gif'))]))->hasAttached(Muscle::whereIn('id', [6, 7, 8])->get())->create([
            'name' => 'Rowing menton prise large',
            'guideline' => 'Garder les omoplate fixes
Ne pas hausser les épaules (main just ext epaule)',
            'heavy_min' => 10,
            'heavy_max' => 12,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 2.37,
        ]);
        Muscle::find(6)->setIntensity($exercise->id, 0.5);
        Muscle::find(7)->setIntensity($exercise->id, 1);
        Muscle::find(8)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/kickback.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/kickback.gif'))]))->hasAttached(Muscle::whereIn('id', [20, 21, 22])->get())->create([
            'name' => 'Kickback',
            'guideline' => 'Coudes pointent vers les hanches
Coudes sérré',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 3.92,
        ]);
        Muscle::find(20)->setIntensity($exercise->id, 0.25);
        Muscle::find(21)->setIntensity($exercise->id, 1);
        Muscle::find(22)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/rowing-halteres-banc-incline-prise-neutre.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/rowing-halteres-banc-incline-prise-neutre.gif'))]))->hasAttached(Muscle::whereIn('id', [15, 16])->get())->create([
            'name' => 'Rowing haltères incliné',
            'guideline' => 'omoplates fixes
pencher le plus possile le torse
Coude le plus collé au torse
prise supination ou une prise neutre
prendre le plus loint possible',
            'heavy_min' => 8,
            'heavy_max' => 10,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 2.93,
        ]);
        Muscle::find(15)->setIntensity($exercise->id, 1);
        Muscle::find(16)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/shrugs-avec-halteres.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/shrugs-avec-halteres.gif'))]))->hasAttached(Muscle::whereIn('id', [16])->get())->create([
            'name' => 'Shrugs aux haltères',
            'guideline' => 'Bien remonter le bras - Aller de l\'arrière vers l\'avant lors de la monté - lever tete ',
            'heavy_min' => 8,
            'heavy_max' => 10,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 3.94,
        ]);
        Muscle::find(16)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/oiseau-assis-sur-banc.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/oiseau-assis-sur-banc.gif'))]))->hasAttached(Muscle::whereIn('id', [7, 8])->get())->create([
            'name' => 'Elevation arrière buste penché',
            'guideline' => 'Coudes vers l\'exterieur et bien reculer + tendre bras
buste penché
prise pronation/neutre
Ne pas bouger les omoplates (pousser en avant)',
            'heavy_min' => 10,
            'heavy_max' => 12,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 1.69,
        ]);
        Muscle::find(7)->setIntensity($exercise->id, 0.5);
        Muscle::find(8)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/curl-inverse-barre.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/curl-inverse-barre.gif'))]))->hasAttached(Muscle::whereIn('id', [18, 19, 20])->get())->create([
            'name' => 'Curl barre Inversé',
            'guideline' => 'Prise pronation ou neutre
Coude fixe
Coude pas trop devant
poinget niveau epaule',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 3.5,
        ]);
        Muscle::find(18)->setIntensity($exercise->id, 1);
        Muscle::find(19)->setIntensity($exercise->id, 0.25);
        Muscle::find(20)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/curl-concentre.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/curl-concentre.gif'))]))->hasAttached(Muscle::whereIn('id', [18, 19, 20])->get())->create([
            'name' => 'Curl Concentré',
            'guideline' => 'Prise supination ou neutre - Coude légèrement exterieur epaules et proche torce',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 5.65,
        ]);
        Muscle::find(18)->setIntensity($exercise->id, 0.25);
        Muscle::find(19)->setIntensity($exercise->id, 1);
        Muscle::find(20)->setIntensity($exercise->id, 0.25);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/test.jpg', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/test.jpg'))]))->hasAttached(Muscle::whereIn('id', [18, 19, 20])->get())->create([
            'name' => 'Curl barre',
            'guideline' => 'Coude avance sensiblement vers l\'avant',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 3.54,
        ]);
        Muscle::find(18)->setIntensity($exercise->id, 0.25);
        Muscle::find(19)->setIntensity($exercise->id, 0.25);
        Muscle::find(20)->setIntensity($exercise->id, 1);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/fentes-avant.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/fentes-avant.gif'))]))->hasAttached(Muscle::whereIn('id', [1, 3])->get())->create([
            'name' => 'Fentes',
            'guideline' => 'Tirer omoplate en arrière - Regarder devant - légèrement ingliner bassin avant  -dos droit',
            'heavy_min' => 6,
            'heavy_max' => 8,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 5.83,
        ]);
        Muscle::find(1)->setIntensity($exercise->id, 1);
        Muscle::find(3)->setIntensity($exercise->id, 0.5);

        $exercise = Exercise::factory()->hasAttached(File::factory()->create(['data' => 'data:image/' . pathinfo( dirname(__FILE__, 2) . '/files/crunch-poulie-haute.gif', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(dirname(__FILE__, 2) . '/files/crunch-poulie-haute.gif'))]))->hasAttached(Muscle::whereIn('id', [9, 10, 11, 12])->get())->create([
            'name' => 'Crunch poulie',
            'guideline' => 'Commencer bien penché et ramener les
coudes vers les genoux
garder bras tendu en poignet vers genoux
bien déscendre le torce',
            'heavy_min' => 8,
            'heavy_max' => 10,
            'light_min' => 0,
            'light_max' => 0,
            'duration' => 1.96,
        ]);
        Muscle::find(9)->setIntensity($exercise->id, 1);
        Muscle::find(10)->setIntensity($exercise->id, 1);
        Muscle::find(11)->setIntensity($exercise->id, 0.25);
        Muscle::find(12)->setIntensity($exercise->id, 0.25);
        Schema::enableForeignKeyConstraints();
    }
}
