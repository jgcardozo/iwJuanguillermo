
CREATE DATABASE iwJUANtest;


CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `fecha` varchar(20) DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL,
  `url` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);


/* 
 -- si quieren reiniciar el autoincrement
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;
*/

