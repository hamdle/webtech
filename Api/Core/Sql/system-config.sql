/*
    Eric Marty
    Tue 26 Dec 2023
 */
select data from system_config
where reference = :ref
    and user_id = :userId
    and active = 1