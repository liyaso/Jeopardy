<?php
/**
 * Question Bank with Adaptive Difficulty
 * Each question has: id, cat (0-5), difficulty (1=easy, 2=medium, 3=hard), clue, answer
 * Categories: 0=Science, 1=History, 2=Geography, 3=Movies & TV, 4=Sports, 5=Food & Drink
 */

function get_all_questions() {
    return [
        // SCIENCE
        ['id'=>'s1_1','cat'=>0,'difficulty'=>1,'clue'=>'The planet closest to the Sun','answer'=>'mercury'],
        ['id'=>'s1_2','cat'=>0,'difficulty'=>1,'clue'=>'How many legs does a spider have','answer'=>'8'],
        ['id'=>'s1_3','cat'=>0,'difficulty'=>1,'clue'=>'The natural satellite that orbits Earth','answer'=>'moon'],
        ['id'=>'s2_1','cat'=>0,'difficulty'=>2,'clue'=>'The gas that makes up about 78% of Earth\'s atmosphere','answer'=>'nitrogen'],
        ['id'=>'s2_2','cat'=>0,'difficulty'=>2,'clue'=>'The scientist who developed the theory of general relativity','answer'=>'albert einstein'],
        ['id'=>'s2_3','cat'=>0,'difficulty'=>2,'clue'=>'The number of bones in the adult human body','answer'=>'206'],
        ['id'=>'s3_1','cat'=>0,'difficulty'=>3,'clue'=>'The chemical element with atomic number 79','answer'=>'gold'],
        ['id'=>'s3_2','cat'=>0,'difficulty'=>3,'clue'=>'The study of earthquakes is called this','answer'=>'seismology'],
        ['id'=>'s3_3','cat'=>0,'difficulty'=>3,'clue'=>'The particle with no electric charge found in an atom\'s nucleus','answer'=>'neutron'],

        // HISTORY
        ['id'=>'h1_1','cat'=>1,'difficulty'=>1,'clue'=>'The first president of the United States','answer'=>'george washington'],
        ['id'=>'h1_2','cat'=>1,'difficulty'=>1,'clue'=>'World War II ended in this year','answer'=>'1945'],
        ['id'=>'h1_3','cat'=>1,'difficulty'=>1,'clue'=>'The country the Titanic sank near, by ocean name','answer'=>'atlantic'],
        ['id'=>'h2_1','cat'=>1,'difficulty'=>2,'clue'=>'The U.S. president who signed the Emancipation Proclamation','answer'=>'abraham lincoln'],
        ['id'=>'h2_2','cat'=>1,'difficulty'=>2,'clue'=>'The year World War I began','answer'=>'1914'],
        ['id'=>'h2_3','cat'=>1,'difficulty'=>2,'clue'=>'This famous wall dividing a European city fell in November 1989','answer'=>'berlin wall'],
        ['id'=>'h3_1','cat'=>1,'difficulty'=>3,'clue'=>'The ancient Egyptian queen linked to both Julius Caesar and Mark Antony','answer'=>'cleopatra'],
        ['id'=>'h3_2','cat'=>1,'difficulty'=>3,'clue'=>'The first country in the world to grant women the right to vote','answer'=>'new zealand'],
        ['id'=>'h3_3','cat'=>1,'difficulty'=>3,'clue'=>'Napoleon Bonaparte was exiled to this island after Waterloo','answer'=>'saint helena'],

        // GEOGRAPHY
        ['id'=>'g1_1','cat'=>2,'difficulty'=>1,'clue'=>'The largest continent on Earth by land area','answer'=>'asia'],
        ['id'=>'g1_2','cat'=>2,'difficulty'=>1,'clue'=>'The capital city of France','answer'=>'paris'],
        ['id'=>'g1_3','cat'=>2,'difficulty'=>1,'clue'=>'The largest ocean on Earth','answer'=>'pacific'],
        ['id'=>'g2_1','cat'=>2,'difficulty'=>2,'clue'=>'The longest river in the world, flowing through northeastern Africa','answer'=>'nile'],
        ['id'=>'g2_2','cat'=>2,'difficulty'=>2,'clue'=>'The capital city of Australia (not Sydney)','answer'=>'canberra'],
        ['id'=>'g2_3','cat'=>2,'difficulty'=>2,'clue'=>'The country that has more natural lakes than the rest of the world combined','answer'=>'canada'],
        ['id'=>'g3_1','cat'=>2,'difficulty'=>3,'clue'=>'The smallest country in the world by area, located within Rome','answer'=>'vatican city'],
        ['id'=>'g3_2','cat'=>2,'difficulty'=>3,'clue'=>'The only country that borders both the Atlantic and Indian Oceans','answer'=>'south africa'],
        ['id'=>'g3_3','cat'=>2,'difficulty'=>3,'clue'=>'The Strait of Malacca separates Malaysia from this island','answer'=>'sumatra'],

        // MOVIES & TV
        ['id'=>'m1_1','cat'=>3,'difficulty'=>1,'clue'=>'The Pixar movie featuring the line "To infinity and beyond!"','answer'=>'toy story'],
        ['id'=>'m1_2','cat'=>3,'difficulty'=>1,'clue'=>'The streaming service that produces Stranger Things','answer'=>'netflix'],
        ['id'=>'m1_3','cat'=>3,'difficulty'=>1,'clue'=>'The lion cub hero of The Lion King','answer'=>'simba'],
        ['id'=>'m2_1','cat'=>3,'difficulty'=>2,'clue'=>'The director behind both Jurassic Park and Schindler\'s List','answer'=>'steven spielberg'],
        ['id'=>'m2_2','cat'=>3,'difficulty'=>2,'clue'=>'Disney\'s very first feature-length animated film, released in 1937','answer'=>'snow white'],
        ['id'=>'m2_3','cat'=>3,'difficulty'=>2,'clue'=>'The actor who played the Joker in The Dark Knight (2008)','answer'=>'heath ledger'],
        ['id'=>'m3_1','cat'=>3,'difficulty'=>3,'clue'=>'The 1994 film in which Tom Hanks plays a man with a box of chocolates on a park bench','answer'=>'forrest gump'],
        ['id'=>'m3_2','cat'=>3,'difficulty'=>3,'clue'=>'Stanley Kubrick\'s 1968 science fiction epic set in space','answer'=>'2001 a space odyssey'],
        ['id'=>'m3_3','cat'=>3,'difficulty'=>3,'clue'=>'The actress who played Clarice Starling in The Silence of the Lambs','answer'=>'jodie foster'],

        // SPORTS
        ['id'=>'sp1_1','cat'=>4,'difficulty'=>1,'clue'=>'The sport played at the annual Wimbledon Championships','answer'=>'tennis'],
        ['id'=>'sp1_2','cat'=>4,'difficulty'=>1,'clue'=>'How many players from one team are on a basketball court at once','answer'=>'5'],
        ['id'=>'sp1_3','cat'=>4,'difficulty'=>1,'clue'=>'The country that hosts the Tour de France cycling race','answer'=>'france'],
        ['id'=>'sp2_1','cat'=>4,'difficulty'=>2,'clue'=>'The country that has won the most FIFA World Cup titles','answer'=>'brazil'],
        ['id'=>'sp2_2','cat'=>4,'difficulty'=>2,'clue'=>'The Jamaican sprinter who holds the world record in the 100m dash','answer'=>'usain bolt'],
        ['id'=>'sp2_3','cat'=>4,'difficulty'=>2,'clue'=>'The NBA franchise with the most championship titles in league history','answer'=>'boston celtics'],
        ['id'=>'sp3_1','cat'=>4,'difficulty'=>3,'clue'=>'The Winter Olympic sport combining cross-country skiing and rifle shooting','answer'=>'biathlon'],
        ['id'=>'sp3_2','cat'=>4,'difficulty'=>3,'clue'=>'The year the first modern Olympic Games were held in Athens','answer'=>'1896'],
        ['id'=>'sp3_3','cat'=>4,'difficulty'=>3,'clue'=>'The tennis player with the most men\'s Grand Slam singles titles in the Open Era','answer'=>'novak djokovic'],

        // FOOD & DRINK
        ['id'=>'f1_1','cat'=>5,'difficulty'=>1,'clue'=>'The yellow curved fruit monkeys are famously fond of','answer'=>'banana'],
        ['id'=>'f1_2','cat'=>5,'difficulty'=>1,'clue'=>'The main ingredient in guacamole','answer'=>'avocado'],
        ['id'=>'f1_3','cat'=>5,'difficulty'=>1,'clue'=>'The country that invented pizza','answer'=>'italy'],
        ['id'=>'f2_1','cat'=>5,'difficulty'=>2,'clue'=>'The country that produces the most coffee in the world','answer'=>'brazil'],
        ['id'=>'f2_2','cat'=>5,'difficulty'=>2,'clue'=>'The world\'s most expensive spice by weight, harvested from crocus flowers','answer'=>'saffron'],
        ['id'=>'f2_3','cat'=>5,'difficulty'=>2,'clue'=>'The classic French sauce made from egg yolks, clarified butter, and lemon juice','answer'=>'hollandaise'],
        ['id'=>'f3_1','cat'=>5,'difficulty'=>3,'clue'=>'The traditional Japanese fermented soybean paste used in a popular soup','answer'=>'miso'],
        ['id'=>'f3_2','cat'=>5,'difficulty'=>3,'clue'=>'The cooking technique of briefly boiling food then plunging it into ice water','answer'=>'blanching'],
        ['id'=>'f3_3','cat'=>5,'difficulty'=>3,'clue'=>'The French term for a stock reduced until it becomes a thick glaze','answer'=>'glace'],
    ];
}

/**
 * Pick a question for the given category at the target difficulty.
 * Falls back to adjacent difficulties if all questions at that level are used.
 */
function get_question($cat, $difficulty, $seen_ids = []) {
    $all = get_all_questions();
    $search = array_unique(array_filter(
        [$difficulty, $difficulty - 1, $difficulty + 1, 1, 2, 3],
        fn($d) => $d >= 1 && $d <= 3
    ));
    foreach ($search as $diff) {
        $pool = array_values(array_filter($all, fn($q) =>
            $q['cat'] === $cat &&
            $q['difficulty'] === $diff &&
            !in_array($q['id'], $seen_ids)
        ));
        if (!empty($pool)) return $pool[array_rand($pool)];
    }
    return null;
}

/**
 * Adjust difficulty based on last 3 answers.
 * If 2+ correct -> harder. If 2+ wrong -> easier.
 */
function adjust_difficulty($history, $current) {
    $last3 = array_slice($history, -3);
    if (count($last3) < 2) return $current;
    $correct = count(array_filter($last3));
    if ($correct >= 2) return min(3, $current + 1);
    if ((count($last3) - $correct) >= 2) return max(1, $current - 1);
    return $current;
}

function difficulty_label($diff) {
    return [1 => 'Easy', 2 => 'Medium', 3 => 'Hard'][$diff] ?? 'Medium';
}
