# File:problemsolution.ipynb

# Warehouse Robot Navigation with Q-Learning

This project implements a multi-agent system for navigating robots (autobots) in a warehouse environment using Q-learning. It handles complex scenarios including obstacle avoidance, collision prevention, and deadlock resolution.

## Features

- Dynamic grid-based warehouse environment
- Multiple autonomous robots (autobots) with individual goals
- Q-learning based path planning and decision making
- Collision detection and resolution
- Deadlock detection and resolution
- Visualization of robot paths and warehouse layout

## Requirements

- Python 3.7+
- NumPy
- Matplotlib

## Installation

1. Clone this repository:
   ```
   git clone https://github.com/yourusername/warehouse-robot-navigation.git
   cd warehouse-robot-navigation
   ```

2. Install the required packages:
   ```
   pip install numpy matplotlib
   ```

## Usage

Run the main script:

```
python warehouse_navigation.py
```

### Input Format

The program will prompt you for input to define the warehouse layout:

1. First, enter the number of rows in the grid.
2. Then, enter the number of columns in the grid.
3. Next, you'll input the grid layout row by row. Use the following symbols:
   - 'A': Starting position of a robot
   - 'B': Goal position
   - 'X': Obstacle
   - '.': Empty space

Example input for a 4x4 grid:

```
Enter the number of rows in the grid: 4
Enter the number of columns in the grid: 4
Enter the grid layout row by row in the format: 'A', 'X', '.', 'B'
Row 1: A . . B
Row 2: . X X .
Row 3: . X X .
Row 4: B . . A
```

This input creates a 4x4 grid with:
- Two robots ('A') in opposite corners
- Two goals ('B') in the other corners
- A 2x2 obstacle ('X') in the center
- Empty spaces ('.') in the remaining cells

### Output

After processing the input, the program will:

1. Train the robots using Q-learning
2. Display the best path found for each robot
3. Show the total number of movements/commands per robot
4. Provide the average number of commands across all robots
5. Display the maximum number of commands (which determines when the test case finishes)
6. Show episode statistics including steps taken and duration
7. Visualize the paths taken by the robots in the warehouse layout

## How It Works

1. **Environment Setup**: The warehouse is represented as a grid where robots, goals, and obstacles are placed.

2. **Q-Learning**: Each robot uses a Q-learning algorithm to learn optimal paths to its goal.

3. **Collision Handling**: When multiple robots attempt to occupy the same space, the program finds alternative paths using a breadth-first search algorithm.

4. **Deadlock Resolution**: If robots are unable to move for a certain number of steps, the program attempts to resolve the deadlock by moving a robot to a neighboring empty cell.

5. **Visualization**: The final paths of the robots are visualized using Matplotlib, showing the warehouse layout and the path each robot takes.

## Customization

You can modify the following parameters in the code to customize the behavior:

- `max_deadlock`: Maximum number of consecutive deadlocks before resolution (in `WarehouseEnv` class)
- Learning rate, discount factor, and epsilon values (in `QLearningAgent` class)
- Number of training episodes and maximum steps per episode (in `train` function)

## Contributing

Contributions to improve the algorithm, add features, or fix bugs are welcome! Please feel free to submit a pull request or open an issue.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
