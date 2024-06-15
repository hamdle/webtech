/*
    Eric Marty
    Mon 01 Aug 2022
 */
select count(*) as total from workouts
where workouts.user_id = :user_id