<?php
// Warehouse Autobot Simulation - Shortest Path with Matrix Moves

// Define the grid
$grid = [
    ['A', 'X', '.', 'X', 'B'],
    ['.', 'X', '.', '.', '.'],
    ['.', '.', 'X', '.', '.'],
    ['.', '.', '.', '.', '.'],
    ['A', 'X', '.', '.', 'B']
];

// Define autobots
$autobots = [
    ['id' => 1, 'start' => [0, 0], 'end' => [0, 4]],
    ['id' => 2, 'start' => [4, 0], 'end' => [4, 4]]
];

// Define directions (up, right, down, left)
$directions = [[-1, 0], [0, 1], [1, 0], [0, -1]];

// Function to check if a move is valid
function isValidMove($grid, $position) {
    $row = $position[0];
    $col = $position[1];
    return $row >= 0 && $row < count($grid) && $col >= 0 && $col < count($grid[0]) && $grid[$row][$col] != 'X';
}

// Function to find the shortest path using BFS
function findShortestPath($grid, $start, $end) {
    $queue = new SplQueue();
    $queue->enqueue([$start]);
    $visited = array_fill(0, count($grid), array_fill(0, count($grid[0]), false));
    $visited[$start[0]][$start[1]] = true;

    while (!$queue->isEmpty()) {
        $path = $queue->dequeue();
        $current = end($path);

        if ($current == $end) {
            return $path;
        }

        foreach ($GLOBALS['directions'] as $direction) {
            $next = [$current[0] + $direction[0], $current[1] + $direction[1]];
            if (isValidMove($grid, $next) && !$visited[$next[0]][$next[1]]) {
                $newPath = $path;
                $newPath[] = $next;
                $queue->enqueue($newPath);
                $visited[$next[0]][$next[1]] = true;
            }
        }
    }

    return []; // No path found
}

// Function to convert path to matrix moves
// Function to convert path to matrix moves
// Function to convert path to matrix moves in the format "move(row,column)"
function pathToMatrixMoves($path) {
    $moves = [];
    for ($i = 1; $i < count($path); $i++) {
        $move = "move(" . $path[$i][0] . "," . $path[$i][1] . ")";
        $moves[] = $move;
    }
    return $moves;
}

// Simulate movement for both autobots
$paths = [];
$matrixMoves = [];
$times = [];

foreach ($autobots as $autobot) {
    $path = findShortestPath($grid, $autobot['start'], $autobot['end']);
    $paths[$autobot['id']] = $path;
    $matrixMoves[$autobot['id']] = pathToMatrixMoves($path);
    $times[$autobot['id']] = count($path) - 1; // -1 because the number of moves is one less than the number of positions
}

$totalTime = max($times);

// Generate HTML output
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Autobot Simulation - Shortest Path</title>
    <style>
        .grid {
            display: grid;
            grid-template-columns: repeat(5, 50px);
            gap: 1px;
            margin-bottom: 20px;
        }
        .cell {
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .obstacle { background-color: #888; }
        .autobot1 { background-color: #f00; color: white; }
        .autobot2 { background-color: #00f; color: white; }
        .start { background-color: #0f0; }
        .end { background-color: #ff0; }
        .path1 { background-color: rgba(255, 0, 0, 0.5); } /* Red for Autobot 1's path */
        .path2 { background-color: rgba(0, 0, 255, 0.5); } /* Blue for Autobot 2's path */
    </style>
</head>
<body>
    <h1>Warehouse Autobot Simulation - Shortest Path</h1>
    
    <div class="grid" id="grid">
        <?php
        foreach ($grid as $row => $cells) {
            foreach ($cells as $col => $cell) {
                $classes = ['cell'];
                if ($cell == 'X') {
                    $classes[] = 'obstacle';
                } elseif ($cell == 'A') {
                    $classes[] = 'start';
                } elseif ($cell == 'B') {
                    $classes[] = 'end';
                }

                echo '<div class="' . implode(' ', $classes) . '" data-row="' . $row . '" data-col="' . $col . '">' . $cell . '</div>';
            }
        }
        ?>
    </div>
    
    <h2>Simulation Results</h2>
    <?php foreach ($autobots as $autobot): ?>
        <h3>Autobot <?= $autobot['id'] ?></h3>
        <p>Time taken: <?= $times[$autobot['id']] ?> units</p>
        <p>Path: <?= implode(' ', $matrixMoves[$autobot['id']]) ?></p>
    <?php endforeach; ?>
    
    <h3>Total Time: <?= $totalTime ?> units</h3>

    <script>
        // Paths for each autobot
        const paths = <?= json_encode($paths); ?>;
        
        // Function to highlight each step
        function highlightStep(path, autobotClass, delay) {
            path.forEach((position, index) => {
                setTimeout(() => {
                    const cell = document.querySelector(`.cell[data-row="${position[0]}"][data-col="${position[1]}"]`);
                    if (cell) {
                        cell.classList.add(autobotClass);
                    }
                }, delay * index);
            });
        }

        // Animate Autobot 1's path
        highlightStep(paths[1], 'path1', 500); // 500ms delay for each step

        // Animate Autobot 2's path
        highlightStep(paths[2], 'path2', 500); // 500ms delay for each step
    </script>
</body>
</html>
