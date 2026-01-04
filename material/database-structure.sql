SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `ip_api` (
  `id` bigint(20) NOT NULL,
  `ip` varchar(39) NOT NULL,
  `lang` text NOT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `peering_db` (
  `id` bigint(20) NOT NULL,
  `asn` varchar(20) NOT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user_agent` (
  `id` bigint(20) NOT NULL,
  `user_agent` varchar(500) NOT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `whois` (
  `id` bigint(20) NOT NULL,
  `ip` varchar(39) NOT NULL,
  `result` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`result`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `ip_api`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `peering_db`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_agent`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `whois`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ip_api`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `peering_db`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user_agent`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `whois`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;


COMMIT;
