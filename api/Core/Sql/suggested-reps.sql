select reps.amount as reps from workouts
left join exercises on workouts.id = exercises.workout_id
left join reps on exercises.id = reps.exercise_id
where exercises.exercise_type_id = :exercise_type_id
  and workouts.user_id = :user_id
  and workouts.id = :workout_id