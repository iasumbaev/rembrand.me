create temp table users(id bigserial, group_id bigint);
insert into users(group_id) values (1), (1), (1), (2), (1), (3);

select min(id) as min_id, group_id, count(id)
from
  (select id,
          group_id,
          dense_rank() over(order by id) - dense_rank() over(partition by group_id order by id) as group_id_rank
   from users) t
group by group_id,
         group_id_rank
order by min_id;