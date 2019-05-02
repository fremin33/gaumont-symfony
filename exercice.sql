# Rajouter un film (1 point)
INSERT INTO film(name, duration, description, release_date, poster, price) VALUES ('Avengers : Endgame',180,'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias at dolore, facere perferendis quas temporibus totam? Dolorem ea impedit maiores molestias provident quia quibusdam quidem sunt, veritatis. Natus, quos soluta.','2019-04-25 15:57:26','https://i.pinimg.com/originals/11/b7/b8/11b7b8c0092a2a71e4f75d5186709cb6.jpg',5);

# Récupérer tous les noms de films (1 point )
SELECT name FROM film;

# Récupérer les utilisateurs sans doublons ( 1 point )
SELECT *
FROM user
GROUP BY email;

SELECT DISTINCT email
FROM user;

# Supprimer un film ( 1 point )
DELETE FROM film
WHERE id = 21;

# Mise à jour du nom d un film ( 1 point )
UPDATE film SET name = 'nouveauFilm' WHERE id = 22;

# Liste des films triés par le nom ( 1 point )
SELECT *
FROM film
ORDER BY name;

# Liste des films sortis entre 2018 et 2019 ( 1 points )
SELECT *
FROM film
WHERE release_date BETWEEN '2018-01-01' AND '2019-01-01';

# Liste des utilisateurs avec un email gmail ( 1 point )
SELECT *
FROM user
WHERE email LIKE '%gmail.com';

# Rajouter le champ pseudonyme à la table utilisateur ( 1 point )
ALTER TABLE user ADD pseudonyme VARCHAR(50);

# Récupérer les films sorties il y a deux ans et avec le nom qui commence par un "l" (1 point)
SELECT * FROM film
WHERE release_date <= NOW() - INTERVAL 2 YEAR
AND name LIKE 'l%';

# HAVING ( 2 point ) et Left Join ( 2 points )
# On récupère la somme totals des places des films toutes sessions confondu quand le total est supèrieur à 700
SELECT name, SUM(capacity) as total_capacity
FROM film f
LEFT JOIN session s ON s.film_id = f.id
GROUP BY f.id
HAVING total_capacity > 700

# Sous-requête ( 2 points )
#On récupère les sessions des films dont le prix est égal à 9€
SELECT *
FROM session s
WHERE s.film_id IN (
    SELECT f.id
    FROM film f
    WHERE price = 9
  );

#Right Join ( 2 points )
#On affiche les salles qui ont au moins une sessions
SELECT r.name
FROM room r
RIGHT JOIN session s
ON s.room_id = r.id GROUP BY r.id;

# Full Join  ( 2 point )
SELECT * FROM session s
FULL JOIN room r ON r.id = s.room_id;