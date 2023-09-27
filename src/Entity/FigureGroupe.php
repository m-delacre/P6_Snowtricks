<?php

namespace App\Entity;

enum FigureGroupe: string
{
    case grabs = 'grabs';
    case rotations = 'rotations';
    case flips = 'flips';
    case rotationsDesaxees = 'rotations désaxées';
    case slides = 'slides';
    case oneFootTricks = 'one foot tricks';
    case oldSchool = 'old school';
    case sauts = 'sauts';
    case barreDeSlide = 'barre de slide';
}
