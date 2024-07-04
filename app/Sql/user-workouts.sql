/*
    Eric Marty
    Sat 07 May 2022
 */
select *
from workouts
where workouts.user_id = :user_id
order by workouts.start desc
limit :limit offset :offset