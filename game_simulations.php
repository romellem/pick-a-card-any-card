<?php 

const SIMULATIONS = 100000;
const SIZE_OF_DECK = 100;
const SIZE_OF_HAND = 10;


/**
 * @return array
 */
function getHand($size_of_deck, $size_of_hand) {
	$cards = range(1, $size_of_deck);
	shuffle($cards);

	return array_slice($cards, 0, 10);
};

echo "Simulations:  " . SIMULATIONS . "\n";
echo "Size of Deck: " . SIZE_OF_DECK . "\n";
echo "Size of Hand: " . SIZE_OF_HAND . "\n";
echo "==========================\n\n";

echo "thrsh.\twins\tlosses\tpercentage\n";

for ($threshold = 0; $threshold <= SIZE_OF_DECK; $threshold++) {
	$score = ['wins' => 0, 'losses' => 0];

	for ($simluations = 0; $simluations < SIMULATIONS; $simluations++) {
		$hand = getHand(SIZE_OF_DECK, SIZE_OF_HAND);
		$original_hand = $hand;

		for ($i = 0; $i < SIZE_OF_HAND; $i++) {
			$current_card = array_pop($hand);

			if ($current_card > $threshold) {
				break;
			}
		}

		$cards_that_beat_yours = array_filter($original_hand, function($a) use ($current_card) { return $a > $current_card; });
		if ($cards_that_beat_yours) {
			// You lost!
			$score['losses'] += 1;
		} else {
			// You won!
			$score['wins'] += 1;
		}
	}

	$percentage = $score['wins'] / ($score['wins'] + $score['losses']);

	// echo "Threshold: $threshold\t| {$score['wins']} - {$score['losses']} ({$percentage}%)\n";
	echo "$threshold\t{$score['wins']}\t{$score['losses']}\t{$percentage}\n";
}

echo "\nThanks for playing!\n";
