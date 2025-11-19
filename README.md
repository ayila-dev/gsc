#

sudo mkfs.vfat -I -F 32 /dev/sdb

#

sudo mkfs.vfat -F 32 -n USB /dev/sdb

#

sudo dd if=/home/fambfad/Downloads/Win10_22H2_French_x64v1.iso of=/dev/sdb bs=4M status=progress && sync

# Gestion des notes

Voici comment la gestion des notes fonctionne :

1- Une école peut exécuter sa période scolaire en semestre ou trimestre (c'est à l'utilisateur de le définir),

2- Que le choix de la période soit Semestre ou Trimestre :

-   Un trimestre ou un semestre a droit à 03 notes d'interrogations (i1, i2 & i3) par élève.
-   Un trimestre ou un semestre a également droit à 02 notes de devoirs (d1 & d2) par élève.
-   NB : On a au total 03 trimestres et 02 semestres,

3- Ainsi quand l'utilisateur défini la Période(Trimestre => t1, t2, t3 ou Semestre => s1, s2),

4- Il doit aussi définir le type d'évaluation (Interrogation => i1, i2, i3 ou Devoirs => d1, d2) qu'il souhaitrait insérer pour cette période,

5- A l'insertion des notes, le programme devra vérifier non seulement l'existance d'une ligne de notes mais aussi chaque colonne de la ligne existante afin de voir si les notes qui y sont enrégistrées n'appartiennent pas au même type d'évaluation (i1,i2,i3,d1 ou d2). Si c'est le cas renvoyer un message alternatif disant que la note existe déjà pour ce type d'évaluation choisi.
Ex: La note de la première interrogation (i1) existe déjà pour les élèves. Sinon mettre à jour le nouveau type d'évaluation dont les notes viennent d'être renseignées. La vérification se poursuivra pour chaque insertion faite jusqu'a ce que une période scolaire (c'est à dire un trimestre ou un semestre) se terminier en ayant toutes ces notes comme expliquer en 2. C'est uniquement à cette condition qu'une nouvelle ligne peut-être insérée pour une nouvelle période qui commence.
