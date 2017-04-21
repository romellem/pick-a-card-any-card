<?php 

/**
 * @return array
 */
function getHand($highest_card = 100) {
	$cards = range(1, $highest_card);
	shuffle($cards);

	return array_slice($cards, 0, 10);
};

$score = ['wins' => 0, 'losses' => 0];

$play_again = true;
while ($play_again) {
	$hand = getHand(100);
	$original_hand = $hand;

	$sizeof_hand = count($hand);

	for ($i = 0; $i < $sizeof_hand; $i++) {
		$current_card = array_pop($hand);
		echo "Current card is: {$current_card}\n";

		if (count($hand) > 0) {
			$choice = readline('Stop playing (y or n)? ');

			if (strtolower($choice) === 'y') {
				break;
			}
		} else {
			echo "That was the last card in the deck!\n";
		}
	}

	$cards_that_beat_yours = array_filter($original_hand, function($a) use ($current_card) { return $a > $current_card; });

	// Sort for echoes
	sort($cards_that_beat_yours, SORT_NUMERIC);
	sort($original_hand, SORT_NUMERIC);
	if ($cards_that_beat_yours) {
		// You lost!
		echo "You lost! Your card '{$current_card}' lost to:\n";
		echo implode($cards_that_beat_yours, ', ');
		echo "\n";

		$score['losses'] += 1;
	} else {
		// You won!
		echo "You won! Your card '{$current_card}' beat the original hand of:\n";
		echo implode($original_hand, ', ');
		echo "\n";

		$score['wins'] += 1;
	}

	$play_again = (strtolower(readline('Play again (y or n)? ')) === 'y');

	$percentage = 100 * $score['wins'] / ($score['wins'] + $score['losses']);
	echo "\nCurrent score: " . $score['wins'] . " - " . $score['losses'] . " (" . $percentage . "%)\n\n";
}

echo "\nThanks for playing!\n";
