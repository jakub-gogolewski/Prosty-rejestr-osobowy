# Opis projektu
Prosty rejestr osobowy napisany w Symfony. Umożliwia CRUD osób i CRUD adresów dla tej osoby, a także wyszukiwanie rekordów zawierających dowolną frazę lub nawet samą literę.<br /><br /> Używa bazy plikowej sqlite i jest skonteneryzowany. Frontend wykorzystuje trochę bootstrapa i własne style.<br />
<br />Każdej osobie można dodać wiele adresów.

# Sposób uruchomienia
Wystarczy pobrać projekt i wykonać polecenie **docker-compose up** oraz poczekać na zbudowanie aplikacji.
<br /><br />
Aplikacja będzie dostępna pod adresem **127.0.0.1:8000** i ma już trochę przykładowych danych w bazie sqlite **simple_register.db**

# Screeny aplikacji
Widok strony głównej:
![screen1](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/4bb809fb-4193-4478-928d-c6c8fc3975e1)
<br /><br />

Wyszukiwanie po frazie:
![screen2](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/1c9ab208-18ea-42ad-a0ed-8bc97d5220f6)
<br /><br />

Dodawanie osoby:
![image](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/4220ecc3-0c02-4177-ba1a-7d48abaee59d)
<br /><br />

Dodawanie adresu dla tej osoby:
![image](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/bad5af5a-9660-4914-aaa1-1ace1f746fba)
<br /><br />

Jeśli ktoś ma więcej niż jeden adres, mamy opcję wyboru, który chcemy edytować lub usuwać z listy:
![image](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/9280c412-3e12-4ea8-8318-ebcb6d6954ec)

Edycja osoby:
![image](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/fa65bac0-00fa-4619-8265-90cde3256722)
<br /><br />

Edycja adresu:
![image](https://github.com/jakub-gogolewski/Prosty-rejestr-osobowy/assets/68034177/3f6d2d0a-06f2-4447-9037-c8906c50c789)
<br /><br />

