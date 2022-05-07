select *
from workouts
where workouts.user_id = :user_id
order by workouts.start desc
limit :limit