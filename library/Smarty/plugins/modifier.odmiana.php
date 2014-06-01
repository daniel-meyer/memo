<?php

function smarty_modifier_odmiana($liczba,$jeden,$dwa,$siedem)
{
    return Etd_Tool::nounNumer($liczba,$jeden,$dwa,$siedem);
}

