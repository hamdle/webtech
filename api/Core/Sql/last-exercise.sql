select workout_id from workouts
left join exercises on workouts.id = exercises.workout_id
where exercises.user_id = :user_id and exercises.exercise_type_id = :exercise_type_id
order by workouts.start desc
limit 1