/*
    Eric Marty
    Tue 26 Dec 2023
 */
select data from system_config
where reference = :ref
    and user_id in (:userId, 1)
    and active = 1
order by user_id desc