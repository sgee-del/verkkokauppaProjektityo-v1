# 🥕 Lihakauppa

Lihakaupan verkkokauppa on projekti, jonka tarkoituksena on tuoda **lähitilojen tuore ja jäljitettävä ruoka helposti kuluttajien saataville**.  
Sivustolla käyttäjä näkee lähialueen tuottajien valikoiman, tuotteen alkuperän sekä voi tilata ruoan kotiovelleen.

---

## 📌 Projektin tavoite

Projektin päätavoitteena on luoda moderni ja käyttäjäystävällinen verkkopalvelu, joka:
- tarjoaa läpinäkyvän tuotetiedon (tuottaja, sijainti, tuotantotapa, tuoreus)
- mahdollistaa **kertatilaukset** sekä **viikottaiset tilauskset** (esim. "viikottainen ruokakassi")
- toimittaa tuotteet **kotiin kylmäpakattuina**
- tukee paikallista ruoantuotantoa ja vähentää ruokaketjun välikäsiä

---

## 🛠 Käytetyt teknologiat

| Teknologia | Käyttötarkoitus |
|------------|-----------------|
| **HTML/PHP** | Sivuston rakenne |
| **CSS** | Ulkoasu ja responsiivinen muotoilu |
| **JavaScript** | Dynaaminen sisältö, toiminnot, tilausten käsittely logiikka |
| **MySQL** | Tuotteiden, käyttäjien ja tilausten tietokanta |

---

## 📦 Keskeiset ominaisuudet

### 🥬 **Tuotteen näkyvyys ja alkuperä**
- Jokaisella tuotteella näkyy:
  - hinta 
  - tuoreus ja saatavuus  
  - tuotteen alkuperätiedot
  - määrä

### 🧺 **Ostoskorijärjestelmä**
- Lisää tuotteita ostoskoriin  
- Muokkaa määriä  
- Näkee hinnan ja toimituskulut reaaliajassa  

### 👤 **Käyttäjätili**
- Rekisteröityminen ja sisäänkirjautuminen  
- Omat tiedot & toimitusosoitteet  
- Omat tilaukset & historia  

---

## 🗄 Tietokantarakenne (MySQL)

Tietokanta koostuu esimerkiksi seuraavista tauluista:

- **users** – käyttäjät, tunnukset ja osoitteet  
- **products** – lähituotteet, alkuperä ja tuotetiedot  
- **orders** – yksittäiset tilaukset  
- **order_items** – mitä tuotteita kukin tilaus sisältää  
- **categories** - tuotteen kategoria
- **cart** - ostoskori, näyttää ostoskoriin laitetut tuotteet

> Tietokantarakenne kasvaa projektin edetessä.

---

## 📈 Projektin tila

Tämä projekti on kehityksessä.
Uusia ominaisuuksia lisätään jatkuvasti.


## 🚀 Asennus & Käyttöönotto

1. **Kloonaa repositorio**
   ```bash
   git clone https://github.com/kayttaja/projekti.git
