/*
    Eric Marty
    Fri 27 May 2022
 */
select
     workouts.id
 from workouts
          left join exercises on workouts.id = exercises.workout_id
          left join reps on exercises.id = reps.exercise_id
 where
         workouts.user_id = :user_id
   and exercises.exercise_type_id = :exercise_type_id
 order by start desc
 limit 1