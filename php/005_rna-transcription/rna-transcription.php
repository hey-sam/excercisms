<?php

/**
* 
* Converts a DNA nucleotide sequence to it's RNA complement
* 
**/
function toRna($dna_nucleotide)
{
	$dna_nucleotide_len = strlen($dna_nucleotide);

	if ($dna_nucleotide_len > 1)
	{
		$rna_sequence = '';
		for ($i = 0; $i < $dna_nucleotide_len; $i++)
		{
			$rna_sequence .= toRnaNucleotide($dna_nucleotide[$i]);
		}

		return $rna_sequence;
	}

	return toRnaNucleotide($dna_nucleotide);	
}

/**
* 
* Converts a DNA nucleotide to it's RNA complement
* 
**/
function toRnaNucleotide($dna_nucleotide)
{
	switch (strtoupper($dna_nucleotide)) {
		case 'G':
			return 'C';
		case 'C':
			return 'G';
		case 'T':
			return 'A';
		case 'A':
			return 'U';	
		
		default:
			return '_';
	}
}
