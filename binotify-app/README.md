##Deskripsi aplikasi web :
Binotify, aplikasi musik berbasis web pada BNMO. Namun, permasalahannya, BNMO adalah mesin yang kuno sehingga hanya kuat untuk menjalankan sebuah DBMS (PostgreSQL/MariaDB/MySQL) dan PHP murni beserta HTML, CSS, dan Javascript vanilla. Karena Indra tidak paham mengenai hal tersebut,

##Daftar requirement :
XAMPP
Docker

##Cara Instalasai :
###Jika menggunakan XAMPP
1. clone repository ke htdocs yang ada pada folder Aplikasi XAMPP
2. Jalankan XAMPP pada Apache dan MySQL
###Jika menggunakan Docker
1. Clone repository
2. Jalankan Terminal pada folder hasil repository
3. Lakukan Perintah docker-compose build
4. Lalu Lakukan perintah docker-compose up


##Cara Menjalankan Server :
Download terlebih dahulu image dan songs pada link https://drive.google.com/drive/folders/18-64OG7wJp76dd4loc3dVR_Fl4P2TPIF?usp=sharing
Extract pada folder assets pada project.

### Jika menggunakan XAMPP
Masukkan URL berikut localhost/tugas-besar-1/src/frontend/mainpage/index.php pada Web Browser
### Jika menggunakan docker:
Masukkan localhost:8000/frontend/mainpage/index.php

##Screenshot tampilan aplikasi :
DAPAT dilihat pada folder assets

##Pembagian Tugas :

Roy Simbolon
- Halaman Home front-end & back-end
- Halaman detail-lagu back-end
Afrizal Sebastian
- Halaman login front-end & back-end
- Halaman Register front-end & back-end
- Halaman detail album front-end & back-end
- Halaman tambah album/lagu front-end & back-end
- Halaman daftar-user front-end & back-end
Ghebyon Tohada Nainggolan
- Halaman Daftar Album front-end & back-end
- Halaman Search, Sort, and Filter front-end & back-end
- Halaman detail Lagu front-end
