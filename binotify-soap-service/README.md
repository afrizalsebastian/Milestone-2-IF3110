<!-- Improved compatibility of back to top link: See: https://github.com/othneildrew/Best-README-Template/pull/73 -->
<a name="readme-top"></a>
<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->



<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]



<!-- PROJECT LOGO -->
<br />
<div align="center">

  <h3 align="center">SOAP API for Binotify</h3>

  <p align="center">
    API yang berisi Subscription dan Logging
    <br />
    <br />
    <a href="https://gitlab.informatika.org/if3110-2022-k01-02-48/binotify-soap-service/-/issues">Report Bug</a>
    ·
    <a href="https://gitlab.informatika.org/if3110-2022-k01-02-48/binotify-soap-service/-/issues">Request Feature</a>
  </p>
  <br />
</div>



<!-- ABOUT THE PROJECT -->
## Tentang Proyek

Binotify Premium App merupakan salah satu aplikai untuk memberikan layanan lagu premium oleh seorang penyanyi pada pelanggan yang menggunakan aplikasi Binotify App pada milestone sebelumnya. 

Dapat dilihat pada project <a href="https://gitlab.informatika.org/if3110-2022-k01-02-48/binotify-app">Binotify App</a>

Spesifikasi Umum:
* Membuat REST service yang bisa menangani pengelolaan lagu premium oleh seorang penyanyi. Service ini wajib dibuat menggunakan bahasa NodeJS. Kalian juga akan membuat clientnya, menggunakan ReactJS/ReactTS, untuk admin Binotify Premium serta penyanyi dapat menggunakan service ini.
* Membuat SOAP service yang bisa menangani pengajuan request subscription, serta menerima approval/rejection dari admin Binotify Premium. Service dibuat menggunakan JAX-WS (Java Servlet).
* Mengubah beberapa skema basis data dari Binotify App, supaya pengguna dapat melakukan pencarian penyanyi yang menyediakan lagu premium dan bisa meminta untuk berlangganan ke penyanyi.

<br/>

### Tech Stack

* Java
* Maven

<br/>

<!-- GETTING STARTED -->
## Mulai

### Prerequisites
1. Java JDK 11
2. Maven

### Instalasi

_Below is an example of how you can instruct your audience on installing and setting up your app. This template doesn't rely on any external dependencies or services._

1. Clone the repo
   ```sh
   git clone https://gitlab.informatika.org/if3110-2022-k01-02-48/binotify-soap-service.git
   ```
2. cd to Froject Folder
    ```
    cd binotify-soap-service
    ```

3. Compile Java
   ```sh
   mvn clean compile assembly:single
   ```
4. Run the file jar
   ```sh
   java -jar target\soapwebserv-1.0-SNAPSHOT-jar-with-dependencies.jar
   ```
<br/>


<!-- CONTRIBUTING -->
## SOAP Contribution

All SOAP : 13520120

<br/>

<!-- CONTACT -->
## Contact

- Roy H Simbolon - [@roy_simbolon005](https://www.instagram.com/roy_simbolon005/) - 13519068@std.stei.itb.ac.id
- Ghebyon Tohada Nainggolan - [@ghebyon_tona](https://www.instagram.com/ghebyon_tona/) - 13520079@std.stei.itb.ac.id
- Afrizal Sebastian - [@afrizalsebatian](https://www.instagram.com/afrizalsebastian/) - 13520120@std.stei.itb.ac.id

<br/>

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/othneildrew/Best-README-Template.svg?style=for-the-badge
[contributors-url]: https://gitlab.informatika.org/groups/if3110-2022-k01-02-48/-/group_members
[forks-shield]: https://img.shields.io/github/forks/othneildrew/Best-README-Template.svg?style=for-the-badge
[forks-url]: https://github.com/othneildrew/Best-README-Template/network/members
[stars-shield]: https://img.shields.io/github/stars/othneildrew/Best-README-Template.svg?style=for-the-badge
[stars-url]: https://github.com/othneildrew/Best-README-Template/stargazers
[issues-shield]: https://img.shields.io/github/issues/othneildrew/Best-README-Template.svg?style=for-the-badge
[issues-url]: https://github.com/othneildrew/Best-README-Template/issues
[license-shield]: https://img.shields.io/github/license/othneildrew/Best-README-Template.svg?style=for-the-badge
[license-url]: https://github.com/othneildrew/Best-README-Template/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/othneildrew
[product-screenshot]: images/login-page.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Next-url]: https://nextjs.org/


[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB
[React-url]: https://reactjs.org/

[ViteJS]: https://img.shields.io/badge/Vite-20232A?style=for-the-badge&logo=vite&logoColor=646CFF
[Vite-url]: https://vitejs.dev/

[Tailwind]: https://img.shields.io/badge/Tailwind-FFFFFF?style=for-the-badge&logo=TailwindCSS&logoColor=06B6D4
[Tailwind-url]: https://tailwindcss.com/

[TypeScript]: https://img.shields.io/badge/TypeScript-FFFFFF?style=for-the-badge&logo=typescript&logoColor=06B6D4
[TypeScript-url]: https://www.typescriptlang.org/