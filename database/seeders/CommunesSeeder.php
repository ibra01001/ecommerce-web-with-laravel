<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Commune;
use App\Models\Wilaya;

class CommunesSeeder extends Seeder
{
    public function run(): void
    {
        $communes = [
            // Wilaya 01 - Adrar
            '01' => ['Adrar', 'Tamest', 'Charouine', 'Reggane', 'In Zghmir', 'Tit', 'Ksar Kaddour', 'Tsabit', 'Timimoun', 'Ouled Said', 'Zaouiet Kounta', 'Aoulef', 'Timokten', 'Tamantit', 'Fenoughil', 'Tinerkouk', 'Deldoul', 'Sali', 'Akabli', 'Metarfa', 'Ouled Aissa', 'Bouda', 'Aougrout', 'Talmine', 'Bordj Badji Mokhtar', 'Sebaa', 'Ouled Ahmed Timmi'],
            
            // Wilaya 02 - Chlef
            '02' => ['Chlef', 'Tenes', 'Benairia', 'El Karimia', 'Tadjena', 'Taougrit', 'Beni Haoua', 'Sobha', 'Harchoun', 'Ouled Fares', 'Sidi Akkacha', 'Boukadir', 'Beni Rached', 'Talassa', 'Herenfa', 'Oued Goussine', 'Dahra', 'Ouled Abbes', 'Sendjas', 'Zeboudja', 'Oued Sly', 'Abou El Hassan', 'El Marsa', 'Chettia', 'Sidi Abderrahmane', 'Moussadek', 'El Hadjadj', 'Labiod Medjadja', 'Oued Fodda', 'Ouled Ben Abdelkader', 'Bouzghaia', 'Ain Merane', 'Oum Drou', 'Breira', 'Beni Bouateb'],
            
            // Wilaya 03 - Laghouat
            '03' => ['Laghouat', 'Ksar El Hirane', 'Bennasser Benchohra', 'Sidi Makhlouf', 'Hassi Delaa', 'Hassi R\'Mel', 'Ain Mahdi', 'Tadjemout', 'Kheneg', 'Gueltet Sidi Saad', 'Ain Sidi Ali', 'Beidha', 'Brida', 'El Ghicha', 'Hadj Mechri', 'Sebgag', 'Taouiala', 'Tadjrouna', 'Aflou', 'El Assafia', 'Oued Morra', 'Oued M\'Zi', 'El Houaita', 'Sidi Bouzid'],
            
            // Wilaya 04 - Oum El Bouaghi
            '04' => ['Oum El Bouaghi', 'Ain Beida', 'Ain M\'Lila', 'Behir Chergui', 'El Amiria', 'Sigus', 'El Belala', 'Ain Babouche', 'Berriche', 'Ouled Hamla', 'Dhalaa', 'Ain Kercha', 'Hanchir Toumghani', 'El Djazia', 'Ain Fakroun', 'Rahia', 'Ain Zitoun', 'Oued Nini', 'Meskiana', 'Ain Diss', 'Fkirina', 'Souk Naamane', 'Zorg', 'El Fedjoudj Boughrara Saoudi', 'Ouled Zouai', 'Bir Chouhada', 'Ksar Sbahi', 'Oued Endja', 'Ouled Gacem'],
            
            // Wilaya 05 - Batna
            '05' => ['Batna', 'Ghassira', 'Maafa', 'Merouana', 'Seriana', 'Menaa', 'El Madher', 'Tazoult', 'N\'Gaous', 'Guigba', 'Inoughissen', 'Ouyoun El Assafir', 'Djerma', 'Bitam', 'Abdelkader Azil', 'Arris', 'Kimmel', 'Tilatou', 'Ain Djasser', 'Ouled Si Slimane', 'Tigherghar', 'Ain Yagout', 'Fesdis', 'Sefiane', 'Rahbat', 'Tighanimine', 'Lemsane', 'Ksar Bellezma', 'Seggana', 'Ichmoul', 'Foum Toub', 'Beni Foudhala El Hakania', 'Oued El Ma', 'Talkhamt', 'Bouzina', 'Chemora', 'Oued Chaaba', 'Taxlent', 'Gosbat', 'Ouled Aouf', 'Boumagueur', 'Barika', 'Djezzar', 'T\'Kout', 'Ain Touta', 'Hidoussa', 'Teniet El Abed', 'Oued Taga', 'Ouled Fadel', 'Timgad', 'Ras El Aioun', 'Chir', 'Ouled Ammar', 'El Hassi', 'Lazrou', 'Boumia', 'Boulhilat', 'Larbaa'],
            
            // Wilaya 06 - Béjaïa
            '06' => ['Bejaia', 'Amizour', 'Ferraoun', 'Taourirt Ighil', 'Chelata', 'Tamokra', 'Timezrit', 'Souk El Thenine', 'M\'Cisna', 'Tinebdar', 'Tichy', 'Semaoun', 'Kendira', 'Tifra', 'Ighram', 'Amalou', 'Ighil Ali', 'Fenaia Ilmaten', 'Toudja', 'Darguina', 'Sidi Ayad', 'Aokas', 'Beni Djellil', 'Adekar', 'Akbou', 'Seddouk', 'Tazmalt', 'Ait Rizine', 'Chemini', 'Souk Oufella', 'Taskriout', 'Tibane', 'Tala Hamza', 'Barbacha', 'Beni Ksila', 'Ouzellaguen', 'Bouhamza', 'Beni Melikeche', 'Sidi Aich', 'El Kseur', 'Melbou', 'Akfadou', 'Leflaye', 'Kherrata', 'Draa Kaid', 'Tamridjet', 'Ait Smail', 'Boukhelifa', 'Tizi N\'Berber', 'Beni Maouch', 'Oued Ghir', 'Boudjellil'],
            
            // Wilaya 07 - Biskra
            '07' => ['Biskra', 'Oumache', 'Branis', 'Chetma', 'Ouled Djellal', 'Ras El Miaad', 'Besbes', 'Ain Naga', 'Zeribet El Oued', 'El Feidh', 'El Kantara', 'Ain Zaatout', 'El Outaya', 'Djemorah', 'Tolga', 'Lioua', 'Lichana', 'Ourlal', 'M\'Lili', 'Foughala', 'Bordj Ben Azzouz', 'Meziraa', 'Bouchagroun', 'Mekhadma', 'El Ghrous', 'El Hadjeb', 'Sidi Okba', 'M\'Chouneche', 'El Haouch', 'Ain El Ibel', 'Chaiba', 'Khenguet Sidi Nadji', 'Sidi Khaled'],
            
            // Wilaya 08 - Béchar
            '08' => ['Bechar', 'Erg Ferradj', 'Ouled Khoudir', 'Meridja', 'Timoudi', 'Lahmar', 'Beni Ikhlef', 'Tabelbala', 'Taghit', 'El Ouata', 'Boukais', 'Mougheul', 'Abadla', 'Kerzaz', 'Ksabi', 'Tamtert', 'Beni Ounif', 'Mechraa Houari Boumediene', 'Mograr', 'Kenadsa', 'Igli', 'Timoukten', 'Ouled Slama', 'Beni Abbes', 'El Biodh Sidi Cheikh', 'Boussemghoun', 'Taghla', 'Ain Sefra'],
            
            // Wilaya 09 - Blida
            '09' => ['Blida', 'Chrea', 'Bouinan', 'Oued El Alleug', 'Ouled Yaich', 'Chebli', 'Boufarik', 'Soumaa', 'Beni Mered', 'Bougara', 'Larbaâ', 'Oued Djer', 'Benkhelil', 'Souhane', 'Mouzaia', 'El Affroun', 'Chiffa', 'Hammam Melouane', 'Ben Khellil', 'Ain Romana', 'Djebabra', 'Bouarfa', 'Beni Tamou', 'Ouled Slama', 'Ouled Alleug', 'Meftah'],
            
            // Wilaya 10 - Bouira
            '10' => ['Bouira', 'El Asnam', 'Guerrouma', 'Souk El Khemis', 'Kadiria', 'Hanif', 'Dirah', 'Ait Laaziz', 'Taghzout', 'Raouraoua', 'Mezdour', 'Haizer', 'Lakhdaria', 'Maala', 'El Hachimia', 'Aomar', 'Chorfa', 'Bordj Okhriss', 'El Adjiba', 'El Hakimia', 'Ahl El Ksar', 'Bouderbala', 'Zbarbar', 'Ain Bessem', 'Bir Ghbalou', 'Khabouzia', 'Ain Turk', 'Djebahia', 'Aghbalou', 'Taguedit', 'Ain El Hadjar', 'Saharidj', 'Dechmia', 'Ridane', 'Bechloul', 'Boukram', 'Ath Mansour', 'El Khabouzia', 'Ouled Rached', 'Ain Laloui', 'Mchedallah', 'Sour El Ghozlane', 'Ain Bessem', 'Hadjera Zerga', 'Ait Keziz'],
            
            // Wilaya 11 - Tamanrasset
            '11' => ['Tamanrasset', 'Abalessa', 'In Ghar', 'In Guezzam', 'In Salah', 'Tazrouk', 'Tin Zaouaten', 'Idles', 'Foggaret Ezzoua', 'In Amguel'],
            
            // Wilaya 12 - Tébessa
            '12' => ['Tebessa', 'Bir El Ater', 'Cheria', 'Stah Guentis', 'El Aouinet', 'Lahouidjbet', 'Safsaf El Ouesra', 'Hammamet', 'Negrine', 'Bir Mokkadem', 'El Kouif', 'Morsott', 'El Ogla', 'Bir Dheheb', 'El Ogla El Malha', 'Guorriguer', 'Bekkaria', 'Boukhadra', 'Ouenza', 'El Ma Labiodh', 'Tlidjene', 'Ain Zerga', 'El Meridj', 'Boulhaf Dyr', 'Bedjene', 'El Mesraa', 'Oum Ali', 'Ferkane'],
            
            // Wilaya 13 - Tlemcen
            '13' => ['Tlemcen', 'Beni Mester', 'Ain Tallout', 'Remchi', 'El Fehoul', 'Sabra', 'Ghazaouet', 'Souani', 'Djebala', 'El Gor', 'Oued Chouly', 'Ain Fezza', 'Ouled Mimoun', 'Amieur', 'Ain Youcef', 'Zenata', 'Beni Snous', 'Bab El Assa', 'Dar Yaghmouracene', 'Fellaoucene', 'Azails', 'Sebaa Chioukh', 'Terni Beni Hediel', 'Bensekrane', 'Ain Nehala', 'Hennaya', 'Maghnia', 'Hammam Boughrara', 'Souahlia', 'M\'Sirda Fouaga', 'Ain Fetah', 'El Aricha', 'Souk Thlata', 'Sidi Abdelli', 'Sebdou', 'Beni Ouarsous', 'Sidi Medjahed', 'Beni Boussaid', 'Marsa Ben M\'Hidi', 'Nedroma', 'Sidi Djillali', 'Beni Bahdel', 'El Bouihi', 'Honaine', 'Tianet', 'Ouled Riyah', 'Bouhlou', 'Souk El Khemis', 'Ain Ghoraba', 'Chetouane', 'Mansourah', 'Beni Semiel', 'Ain Kebira'],
            
            // Wilaya 14 - Tiaret
            '14' => ['Tiaret', 'Medroussa', 'Ain Bouchekif', 'Sidi Ali Mellal', 'Ain Zarit', 'Ain Deheb', 'Sidi Bakhti', 'Medrissa', 'Zmalet El Emir Abdelkader', 'Madna', 'Sebt', 'Mellakou', 'Dahmouni', 'Rahouia', 'Mahdia', 'Sougueur', 'Sidi Abdelghani', 'Ain El Hadid', 'Ouled Djerad', 'Naima', 'Meghila', 'Guertoufa', 'Sidi Hosni', 'Djillali Ben Amar', 'Sebaine', 'Tousnina', 'Frenda', 'Ain Kermes', 'Ksar Chellala', 'Rechaiga', 'Nadorah', 'Tagdemt', 'Oued Lilli', 'Mechraa Safa', 'Hamadia', 'Chehaima', 'Takhemaret', 'Sidi Abderrahmane', 'Serghine', 'Bougara', 'Faidja', 'Tidda'],
            
            // Wilaya 15 - Tizi Ouzou
            '15' => ['Tizi Ouzou', 'Ain El Hammam', 'Akbil', 'Freha', 'Souamaa', 'Mechtrass', 'Irdjen', 'Timizart', 'Makouda', 'Draa El Mizan', 'Tizi Gheniff', 'Bounouh', 'Ait Chafaa', 'Frikat', 'Beni Aissi', 'Beni Zmenzer', 'Iferhounene', 'Azazga', 'Iloula Oumalou', 'Yakouren', 'Larbaâ Nath Irathen', 'Tizi Rached', 'Zekri', 'Ouaguenoun', 'Ain Zaouia', 'M\'Kira', 'Ait Yahia', 'Ait Mahmoud', 'Maatkas', 'Ait Boumehdi', 'Abi Youcef', 'Beni Douala', 'Illilten', 'Bouzeguene', 'Ait Aggouacha', 'Ouadhia', 'Azeffoun', 'Tigzirt', 'Djebel Aissa Mimoun', 'Boghni', 'Ifigha', 'Ait Oumalou', 'Tirmitine', 'Akerrou', 'Yatafen', 'Beni Ziki', 'Draa Ben Khedda', 'Ouacif', 'Idjeur', 'Mekla', 'Tizi N\'Tleta', 'Beni Yenni', 'Aghribs', 'Iflissen', 'Boudjima', 'Ait Yahia Moussa', 'Souk El Thenine', 'Ait Khelili', 'Sidi Naamane', 'Iboudraren', 'Agouni Gueghrane', 'Mizrana', 'Imsouhal', 'Tadmait', 'Ait Bouaddou', 'Assi Youcef', 'Ait Toudert'],
            
            // Wilaya 16 - Algiers
            '16' => ['Sidi M\'Hamed', 'El Madania', 'Belouizdad', 'Bab El Oued', 'Bologhine', 'Casbah', 'Oued Koriche', 'Bir Mourad Rais', 'El Biar', 'Bouzareah', 'Birkhadem', 'El Harrach', 'Baraki', 'Oued Smar', 'Bachdjerrah', 'Hussein Dey', 'Kouba', 'Bourouba', 'Dar El Beida', 'Bab Ezzouar', 'Ben Aknoun', 'Dely Brahim', 'Hammamet', 'Rais Hamidou', 'Djasr Kasentina', 'El Mouradia', 'Hydra', 'Mohammadia', 'Bordj El Kiffan', 'El Magharia', 'Beni Messous', 'Les Eucalyptus', 'Birtouta', 'Tessala El Merdja', 'Ouled Chebel', 'Sidi Moussa', 'Ain Taya', 'Bordj El Bahri', 'El Marsa', 'H\'raoua', 'Rouiba', 'Reghaia', 'Ain Benian', 'Staoueli', 'Zeralda', 'Mahelma', 'Rahmania', 'Souidania', 'Cheraga', 'Ouled Fayet', 'El Achour', 'Draria', 'Douera', 'Baba Hassen', 'Khraissia', 'Saoula'],
            
            // Wilaya 17 - Djelfa
            '17' => ['Djelfa', 'Moudjbara', 'El Guedid', 'Hassi Bahbah', 'Ain Maabed', 'Sed Rahal', 'Faidh El Botma', 'Birine', 'Bouira Lahdab', 'Zaccar', 'El Khemis', 'Sidi Baizid', 'M\'Liliha', 'El Idrissia', 'Douis', 'Hassi El Euch', 'Messaad', 'Guettara', 'Ain Ibel', 'Ain Oussera', 'Benhar', 'Hassi Fedoul', 'Charef', 'Sidi Ladjel', 'Oum Laadham', 'Dar Chioukh', 'Ain Chouhada', 'Ain El Ibel', 'Tadmit', 'Had Sahary', 'Guernini', 'Selmana', 'Ain Feka', 'Deldoul', 'Zaafrane', 'Amourah'],
            
            // Wilaya 18 - Jijel
            '18' => ['Jijel', 'Erraguene', 'El Aouana', 'Ziama Mansouriah', 'Taher', 'Emir Abdelkader', 'Chekfa', 'Chahna', 'El Milia', 'Sidi Maarouf', 'Settara', 'El Ancer', 'Sidi Abdelaziz', 'Kaous', 'Ghebala', 'Bouraoui Belhadef', 'Djimla', 'Selma Benziada', 'Boussif Ouled Askeur', 'El Kennar Nouchfi', 'Ouled Yahia Khedrouche', 'Boudriaa Ben Yadjis', 'Kheiri Oued Adjoul', 'Texenna', 'Djemaa Beni Habibi', 'Bordj Taher', 'Ouled Rabah', 'Ouadjana'],
            
            // Wilaya 19 - Sétif
            '19' => ['Setif', 'Ain El Kebira', 'Beni Aziz', 'Ouled Sidi Ahmed', 'Boutaleb', 'Ain Roua', 'Draa Kebila', 'Bir El Arch', 'Beni Chebana', 'Ouled Tebben', 'Hamma', 'Maoklane', 'Guenzet', 'Ain Legraj', 'Ain Abessa', 'Dehamcha', 'Babor', 'Guidjel', 'Ain Lahdjar', 'Bousselam', 'El Eulma', 'Djemila', 'Beni Ouartilane', 'Rosfa', 'Ouled Addouane', 'Belaa', 'Ain Arnat', 'Amoucha', 'Ain Oulmane', 'Beidha Bordj', 'Bouandas', 'Bazer Sakra', 'Hammam Essokhna', 'Mezloug', 'Bir Haddada', 'Serdj El Ghoul', 'Harbil', 'El Ouricia', 'Tizi N\'Bechar', 'Salah Bey', 'Ain Azal', 'Guellal', 'Ain Karcha', 'Bougaa', 'Bordj Ghedir', 'Talaifacene', 'Beni Fouda', 'Tachouda', 'Beni Mouhli', 'Ouled Sabor', 'Guelta Zerka', 'Oued El Barad', 'Tella', 'Ain Sebt', 'Hammam Guergour', 'Ait Naoual Mezada', 'Ksar El Abtal', 'Beni Hocine', 'Ait Tizi', 'Maouia'],
            
            // Wilaya 20 - Saïda
            '20' => ['Saida', 'Doui Thabet', 'Ain El Hadjar', 'Ouled Khaled', 'Moulay Larbi', 'Youb', 'Hounet', 'Sidi Amar', 'Sidi Boubekeur', 'El Hassasna', 'Maamora', 'Sidi Ahmed', 'Ain Sekhouna', 'Ouled Brahim', 'Tircine', 'Ain Soltane'],
            
            // Wilaya 21 - Skikda
            '21' => ['Skikda', 'Ain Zouit', 'El Hadaiek', 'Azzaba', 'Djendel Saadi Mohamed', 'Ain Cherchar', 'Bekkouche Lakhdar', 'Beni Zid', 'Kerkera', 'Ouled Attia', 'Oued Zehour', 'Collo', 'Beni Bachir', 'Zerdaza', 'Ouled Hebaba', 'Zitouna', 'El Harrouch', 'Ramdane Djamel', 'Ouled Hbaba', 'Sidi Mezghiche', 'Emdjez Edchich', 'Beni Oulbane', 'Ain Bouziane', 'Ramdane Djamel', 'Salah Bouchaour', 'Tamalous', 'Ain Kechra', 'Oum Toub', 'Beni Bechir', 'Ouldja Boulbalout', 'Kanoua', 'Essebt', 'Khenaifis', 'Hamraia', 'El Ghedir', 'Bouchtata', 'Ouled Atia', 'Filfila'],
            
            // Wilaya 22 - Sidi Bel Abbès
            '22' => ['Sidi Bel Abbes', 'Tessala', 'Sidi Brahim', 'Badredine El Mokrani', 'Fillaoucene', 'Lamtar', 'Ain Thrid', 'Moulay Slissen', 'Sidi Yacoub', 'Telagh', 'Mezaourou', 'Boukhanefis', 'Sidi Ali Boussidi', 'Badredine', 'Marhoum', 'Tafissour', 'Amarnas', 'Tilmouni', 'Sidi Lahcene', 'Ain El Berd', 'Sfissef', 'Ain Adden', 'Ain Tindamine', 'Sidi Ali Benyoub', 'Sehala', 'Mostefa Ben Brahim', 'Telagh', 'Hassi Zahana', 'Hassi Dahou', 'Ouled Khaled', 'Sidi Khaled', 'Ain El Kebira', 'Sidi Brahim', 'Belarbi', 'Moulay Slissen', 'Ras El Ma', 'Sidi Hamadouche', 'Tabia', 'Merine', 'Teghalimet', 'Sidi Chaib', 'Ras El Ma', 'Ben Badis', 'Sidi Khaled', 'Hassi Zehana', 'Redjem Demouche', 'Zerouala', 'Makedra', 'Tenira', 'Moulay Slissen', 'El Hacaiba', 'Hassi Dahou', 'Amarnas', 'Oued Sebaa', 'Lamtar', 'Sidi Daho Zairs', 'Ain Trid', 'Merine'],
            
            // Wilaya 23 - Annaba
            '23' => ['Annaba', 'Berrahal', 'El Hadjar', 'Ain Berda', 'El Bouni', 'Oued El Aneb', 'Cheurfa', 'Seraidi', 'El Eulma', 'Treat', 'Sidi Amar'],
            
            // Wilaya 24 - Guelma
            '24' => ['Guelma', 'Nechmaya', 'Bouati Mahmoud', 'Oued Zenati', 'Tamlouka', 'Oued Fragha', 'Ain Sandel', 'Bouhamdane', 'Medjez Amar', 'Bordj Sabath', 'Hammam Debagh', 'Bouchegouf', 'Khezara', 'Belkheir', 'Djeballah Khemissi', 'Ain Makhlouf', 'Ain Ben Beida', 'Khezara', 'Boumahra Ahmed', 'Medjez Sfa', 'Bouati Mahmoud', 'Dahouara', 'Heliopolis', 'Ain Larbi', 'Ras El Agba', 'Roknia', 'Sellaouen', 'Tamlouka', 'Hammam N\'Bail', 'Ain Fekka', 'Guellat Bou Sbaa', 'Ain Reggada'],

            // Wilaya 25 - Constantine
            '25' => ['Constantine', 'Hamma Bouziane', 'Didouche Mourad', 'El Khroub', 'Ain Abid', 'Zighoud Youcef', 'Ouled Rahmoune', 'Ain Smara', 'Beni Hamiden', 'Messaoud Boudjeriou', 'Ibn Ziad', 'Ben Badis'],
            
            // Wilaya 26 - Médéa
            '26' => ['Medea', 'Ouzera', 'Ouled Maaref', 'Ain Boucif', 'Derrag', 'El Omaria', 'Ouled Deide', 'El Azizia', 'Souagui', 'Ouled Brahim', 'Tizi Mahdi', 'Sidi Naamane', 'Beni Slimane', 'El Hamdania', 'Berrouaghia', 'Seghouane', 'Sidi Ziane', 'Chahbounia', 'Tafraout', 'Bou Aiche', 'El Guelb El Kebir', 'Zoubiria', 'Ksar El Boukhari', 'El Ouinet', 'Boghar', 'Sidi Zahar', 'Tablat', 'Deux Bassins', 'Draa Essamar', 'Cheniguel', 'Ain Ouksir', 'Oued Harbil', 'Benchicao', 'Ain Boucif', 'Hannacha', 'Kef Lakhdar', 'Chellalet El Adhaoura', 'Bouaichoune', 'Khams Djouamaa', 'Bir Ben Laabed', 'Mezerana', 'Mihoub', 'Baata', 'Tamesguida', 'El Aissaouia', 'Ouled Antar', 'Bouchrahil', 'Rebaia', 'Djouab', 'Tlatet Eddouar', 'Aziz', 'Ouled Hellal', 'Tizi Mahdi', 'Ouamri', 'Sidi Errabia', 'Bouskene', 'Chellaala', 'Ouled Bouachra', 'Aissaouia', 'Bouaiche', 'Beni Slimane', 'Damiat', 'Sidi Damed', 'Oued Harbil'],
            
            // Wilaya 27 - Mostaganem
            '27' => ['Mostaganem', 'Sayada', 'Fornaka', 'Stidia', 'Ain Nouissy', 'Hassi Mamèche', 'Ain Tedles', 'Sidi Ali', 'Kheiredine', 'Sidi Lakhdar', 'Achaacha', 'Khadra', 'Nekmaria', 'Sidi Belattar', 'Oued El Kheir', 'El Hassiane', 'Touahria', 'Sirat', 'Ain Sidi Cherif', 'Mesra', 'Mansourah', 'Souaflia', 'Ouled Boughalem', 'Ouled Maallah', 'Mazagran', 'Hassi Mamèche', 'Ain Boudinar', 'Tazgait', 'Saf Saf', 'Bouguirat', 'Abdelmalek Ramdane', 'Hadjadj', 'Mesra'],
            
            // Wilaya 28 - M'Sila
            '28' => ['M\'Sila', 'Maadid', 'Hammam Dhalaa', 'Ouled Derraj', 'Tarmount', 'Mtarfa', 'Khoubana', 'M\'Cif', 'Chellal', 'Ouled Madhi', 'Magra', 'Berhoum', 'Aïn El Khadra', 'Ouanougha', 'Bou Saada', 'Ouled Sidi Brahim', 'Sidi Aissa', 'Ain El Hadjel', 'Sidi Hadjeres', 'Sidi M\'Hamed', 'Tamsa', 'Ben Srour', 'Ouled Addi Guebala', 'Belaiba', 'Ain Fares', 'Ain Errich', 'Bou Saada', 'El Houamed', 'El Hamel', 'Ouled Mansour', 'Magra', 'Bir Foda', 'Hammam Dhalaa', 'Zarzour', 'Mohamed Boudiaf', 'Ouled Slimane', 'El Aissaouia', 'Khettouti Sed Djir', 'Ouled Sidi Brahim', 'Slim', 'Ain Khadra', 'Djebel Messaad', 'Benzouh', 'Sidi Ameur'],
            
            // Wilaya 29 - Mascara
            '29' => ['Mascara', 'Bou Hanifia', 'Tizi', 'Hacine', 'Maoussa', 'Teghennif', 'Tighennif', 'Sidi Kada', 'Zelmata', 'Oued El Abtal', 'Ain Ferah', 'Ghriss', 'Froha', 'Matemore', 'Makdha', 'Sidi Boussaid', 'El Bordj', 'Ain Fekan', 'Benian', 'Khalouia', 'El Menaouer', 'Oued Taria', 'Aouf', 'Ain Fares', 'Ain Ferah', 'Alaimia', 'Sehailia', 'Mohammadia', 'Sidi Abdelmoumene', 'Ferraguig', 'El Ghomri', 'Sedjerara', 'Moctadouz', 'Ain Ferah', 'Guerdjoum', 'Bouhanifia', 'Hachem', 'Nesmot', 'Sidi Abdeldjebar', 'Chorfa', 'El Gaada', 'Zahana', 'Mohammadia', 'Sidi Abdeldjebar', 'Ras Ain Amirouche', 'Aouf', 'Gharrous'],
            
            // Wilaya 30 - Ouargla
            '30' => ['Ouargla', 'Ain Beida', 'N\'Goussa', 'Hassi Messaoud', 'Rouissat', 'Ain El Beida', 'Sidi Khouiled', 'Hassi Ben Abdellah', 'Tebesbest', 'El Alia', 'Tamacine', 'Touggourt', 'Nezla', 'Zaouia El Abidia', 'Taibet', 'M\'Naguer', 'Temacine', 'Blidet Amor', 'El Hadjira', 'Taibet', 'Megarine', 'Sidi Slimane', 'Benaceur', 'M\'Rara', 'Hassi Ben Abdallah', 'El Borma', 'Tebesbest', 'El Alia', 'Nezla'],
            
            // Wilaya 31 - Oran
            '31' => ['Oran', 'Bir El Djir', 'Es Senia', 'Arzew', 'Bethioua', 'Marsat El Hadjadj', 'Ain Turk', 'El Ancar', 'Oued Tlelat', 'Tafraoui', 'Sidi Chami', 'Boufatis', 'Mers El Kebir', 'Bousfer', 'El Karma', 'El Braya', 'Hassi Bounif', 'Hassi Ben Okba', 'Ben Freha', 'Sidi Ben Yebka', 'Messerghin', 'Boutlelis', 'Ain Kerma', 'Ain Biya', 'Gdyel', 'Ain El Bia'],
            
            // Wilaya 32 - El Bayadh
            '32' => ['El Bayadh', 'Rogassa', 'Stitten', 'Brezina', 'Ghassoul', 'Boualem', 'El Abiodh Sidi Cheikh', 'Ain El Orak', 'Arbaouat', 'Bougtoub', 'El Mehara', 'Tousmouline', 'El Kheiter', 'Kef El Ahmar', 'Boussemghoun', 'Chellala', 'Kraakda', 'El Bnoud', 'Cheguig', 'Ain Adss', 'Bougtob', 'Sidi Ameur'],
            
            // Wilaya 33 - Illizi
            '33' => ['Illizi', 'Djanet', 'Debdeb', 'Bordj Omar Driss', 'Bordj El Haouasse', 'In Amenas', 'Debdeb'],
            
            // Wilaya 34 - Bordj Bou Arreridj
            '34' => ['Bordj Bou Arreridj', 'Ras El Oued', 'Bordj Zemoura', 'Mansourah', 'El Achir', 'Ain Taghrout', 'Bordj Ghdir', 'Sidi Embarek', 'El Hamadia', 'Medjana', 'Teniet En Nasr', 'Hasnaoua', 'Khelil', 'El Main', 'Ouled Brahem', 'Ouled Dahmane', 'Djaafra', 'Bir Kasdali', 'Ben Daoud', 'Ghilassa', 'Rabta', 'Haraza', 'El Achir', 'Tixter', 'El Mehir', 'Belimour', 'Aïn Tesra', 'Bordj Zemmoura', 'Colla', 'Taglait', 'Ouled Sidi Brahim', 'Ksour', 'Tefreg', 'Ain Tagourait', 'Taghzout'],
            
            // Wilaya 35 - Boumerdès
            '35' => ['Boumerdes', 'Boudouaou', 'Afir', 'Bordj Menaiel', 'Baghlia', 'Sidi Daoud', 'Naciria', 'Djinet', 'Isser', 'Zemmouri', 'Si Mustapha', 'Tidjelabine', 'Chabet El Ameur', 'Thenia', 'Timezrit', 'Corso', 'Ouled Moussa', 'Larbatache', 'Bouzegza Keddara', 'Taourga', 'Ouled Aissa', 'Ben Choud', 'Dellys', 'Ammal', 'Beni Amrane', 'Souk El Had', 'Boudouaou El Bahri', 'Ouled Heddadj', 'Legata', 'Hammedi', 'Khemis El Khechna', 'El Kharrouba', 'Issers'],
            
            // Wilaya 36 - El Tarf
            '36' => ['El Tarf', 'Bouhadjar', 'Ben M\'Hidi', 'Bougous', 'El Kala', 'Ain El Assel', 'El Aioun', 'Bouteldja', 'Souarekh', 'Berrihane', 'Lac des Oiseaux', 'Chefia', 'Drean', 'Chihani', 'Chebaita Mokhtar', 'Besbes', 'Asfour', 'Echatt', 'Zitouna', 'Ain Kerma', 'Oued Zitoun', 'Hammam Beni Salah', 'Raml Souk', 'Ain El Karma'],
            
            // Wilaya 37 - Tindouf
            '37' => ['Tindouf', 'Oum El Assel', 'Tindouf'],
            
            // Wilaya 38 - Tissemsilt
            '38' => ['Tissemsilt', 'Theniet El Had', 'Bordj Bounaama', 'Bordj El Emir Abdelkader', 'Lardjem', 'Melaab', 'Sidi Lantri', 'Beni Chaib', 'Larbaa', 'Maasem', 'Sidi Boutouchent', 'Ammari', 'Youssoufia', 'Khemisti', 'Ouled Bessem', 'Sidi Abed', 'Tamalaht', 'Sidi Slimane', 'Boucaid', 'Larbaa', 'Layoune', 'Beni Lahcene'],
            
            // Wilaya 39 - El Oued
            '39' => ['El Oued', 'Robbah', 'Oued El Alenda', 'Bayadha', 'Nakhla', 'Guemar', 'Kouinine', 'Reguiba', 'Hamraia', 'Taghzout', 'Debila', 'Hassani Abdelkrim', 'Hassi Khalifa', 'Taleb Larbi', 'Douar El Ma', 'Sidi Aoun', 'Trifaoui', 'Magrane', 'Beni Guecha', 'Ourmes', 'Still', 'M\'Rara', 'Sidi Khellil', 'Tendla', 'El Ogla', 'Mih Ouansa', 'Oued El Alenda', 'Ogla', 'Ben Guecha'],
            
            // Wilaya 40 - Khenchela
            '40' => ['Khenchela', 'M\'Toussa', 'Kais', 'Baghai', 'El Hamma', 'Ain Touila', 'Tamza', 'Ensigha', 'Ouled Rechache', 'El Mahmal', 'M\'Sara', 'Yabous', 'Khirane', 'Chechar', 'Djellal', 'Babar', 'Taouzianat', 'N\'Sigha', 'Remila', 'Ouled Rechache', 'El Oueldja'],
            
            // Wilaya 41 - Souk Ahras
            '41' => ['Souk Ahras', 'Sedrata', 'Hanancha', 'Mechroha', 'Ouled Driss', 'Tiffech', 'Zaarouria', 'Taoura', 'Drea', 'Haddada', 'Khedara', 'Merahna', 'Ouled Moumen', 'Bir Bouhouche', 'Mdaourouche', 'Oum El Adhaim', 'Ain Zana', 'Ain Soltane', 'Quillen', 'Sidi Fredj', 'Safel El Ouiden', 'Ragouba', 'Khemissa', 'Oued Keberit', 'Terraguelt', 'Zouabi'],
            
            // Wilaya 42 - Tipaza
            '42' => ['Tipaza', 'Menaceur', 'Larhat', 'Douaouda', 'Bouharoun', 'Khemisti', 'Aghabal', 'Hadjout', 'Sidi Amar', 'Gouraya', 'Fouka', 'Bou Ismail', 'Ahmer El Ain', 'Bou Haroun', 'Sidi Ghiles', 'Messelmoun', 'Sidi Rached', 'Kolea', 'Attatba', 'Sidi Semiane', 'Beni Milleuk', 'Hadjerat Ennous', 'Meurad', 'Cherchell', 'Damous', 'Tipaza', 'Nador', 'Chaiba'],
            
            // Wilaya 43 - Mila
            '43' => ['Mila', 'Ferdjioua', 'Chelghoum Laid', 'Oued Athmania', 'Ain Mellouk', 'Telerghma', 'Oued Seguen', 'Tadjenanet', 'Benyahia Abderrahmane', 'Oued Endja', 'Ahmed Rachedi', 'Ouled Khellouf', 'Tiberguent', 'Bouhatem', 'Rouached', 'Tessala Lemtai', 'Grarem Gouga', 'Sidi Merouane', 'Tassadane Haddada', 'Derradji Bousselah', 'Minar Zarza', 'Amira Arras', 'Ain Tine', 'El Mechira', 'Sidi Khelifa', 'Zeghaia', 'Elayadi Barbes', 'Ain Beida Harriche', 'Yahia Beni Guecha', 'Terrai Bainen'],
            
            // Wilaya 44 - Aïn Defla
            '44' => ['Ain Defla', 'Miliana', 'Boumedfaa', 'Khemis Miliana', 'Hammam Righa', 'Arib', 'Djelida', 'El Amra', 'Bourached', 'El Attaf', 'El Abadia', 'Djendel', 'Oued Chorfa', 'Ain Lechiakh', 'Oued Djemaa', 'Rouina', 'Zeddine', 'El Hassania', 'Bir Ould Khelifa', 'Ain Soltane', 'Tarik Ibn Ziad', 'Bordj Emir Khaled', 'Ain Torki', 'Sidi Lakhdar', 'Ben Allal', 'Ain Benian', 'Hoceinia', 'Barbouche', 'Djemaa Ouled Cheikh', 'Mekhatria', 'Bathia', 'Tacheta Zegagha', 'Ain Bouyahia', 'El Maine', 'Tiberkanine', 'Belaas'],
            
            // Wilaya 45 - Naâma
            '45' => ['Naama', 'Mecheria', 'Ain Sefra', 'Tiout', 'Sfissifa', 'Moghrar', 'Assela', 'Djeniane Bourezg', 'Ain Ben Khelil', 'Makman Ben Amer', 'Kasdir', 'El Biodh'],
            
            // Wilaya 46 - Aïn Témouchent
            '46' => ['Ain Temouchent', 'Chaabet El Ham', 'Ain Kihal', 'Hammam Bouhadjar', 'Bou Zedjar', 'Oued Berkeche', 'Aghlal', 'Terga', 'Ain El Arbaa', 'Tamzoura', 'Chentouf', 'Sidi Ben Adda', 'Aoubellil', 'El Malah', 'Sidi Boumediene', 'Oued Sabah', 'Ouled Boudjemaa', 'Ain Tolba', 'El Amria', 'Hassi El Ghella', 'Hassasna', 'Sidi Safi', 'Oulhaca El Gheraba', 'Tadmaya', 'El Emir Abdelkader', 'El Messaid', 'Ouled Kihel', 'Beni Saf'],
            
            // Wilaya 47 - Ghardaïa
            '47' => ['Ghardaia', 'El Meniaa', 'Dhayet Bendhahoua', 'Berriane', 'Metlili', 'El Atteuf', 'Zelfana', 'Sebseb', 'Bounoura', 'Hassi Fehal', 'Hassi Gara', 'Mansoura'],
            
            // Wilaya 48 - Relizane
            '48' => ['Relizane', 'Oued Rhiou', 'Belhacel', 'Mazouna', 'Kalaa', 'Ain Tarek', 'Oued Essalem', 'Ouled Aiche', 'Sidi Lazreg', 'El Hamadna', 'Sidi Saada', 'Ouled Sidi Mihoub', 'Ain Rahma', 'Yellel', 'Oued El Djemaa', 'Ramka', 'Mendes', 'Lahlef', 'Beni Dergoun', 'Sidi M\'Hamed Ben Ali', 'El Matmar', 'Sidi Khettab', 'Ammi Moussa', 'Zemmoura', 'Beni Zentis', 'Souk El Had', 'Dar Ben Abdellah', 'El Guettar', 'Hamri', 'El H\'Madna', 'Djidiouia', 'Ain Tarek', 'Oued Rhiou', 'Lahlef', 'Yellel', 'Sidi M\'Hamed Benaouda', 'Had Echkalla', 'Bendaoud', 'Ouarizane'],
            
            // Wilaya 49 - Timimoun (formerly part of Adrar)
            '49' => ['Timimoun', 'Ouled Said', 'Tinerkouk', 'Deldoul', 'Charouine', 'Talmine', 'Aougrout', 'Ksar Kaddour'],
            
            // Wilaya 50 - Bordj Badji Mokhtar (formerly part of Adrar)
            '50' => ['Bordj Badji Mokhtar', 'Timiaouine'],
            
            // Wilaya 51 - Ouled Djellal (formerly part of Biskra)
            '51' => ['Ouled Djellal', 'Sidi Khaled', 'Ras El Miaad', 'Besbes', 'Doucen', 'Chaiba'],
            
            // Wilaya 52 - Béni Abbès (formerly part of Béchar)
            '52' => ['Beni Abbes', 'Tabelbala', 'Igli', 'El Ouata', 'Kerzaz', 'Timoudi', 'Ksabi', 'Tamtert'],
            
            // Wilaya 53 - In Salah (formerly part of Tamanrasset)
            '53' => ['In Salah', 'Foggaret Ezzoua', 'In Ghar'],
            
            // Wilaya 54 - In Guezzam (formerly part of Tamanrasset)
            '54' => ['In Guezzam', 'Tin Zaouaten'],
            
            // Wilaya 55 - Touggourt (formerly part of Ouargla)
            '55' => ['Touggourt', 'Tebesbest', 'Nezla', 'Zaouia El Abidia', 'Taibet', 'Tamacine', 'Blidet Amor', 'Megarine', 'Sidi Slimane', 'M\'Naguer'],
            
            // Wilaya 56 - Djanet (formerly part of Illizi)
            '56' => ['Djanet', 'Bordj El Haouas'],
            
            // Wilaya 57 - El M'Ghair (formerly part of El Oued)
            '57' => ['El M\'Ghair', 'Djamaa', 'Sidi Amrane', 'Sidi Khelil', 'Tendla', 'Oum Touyour', 'Sidi Slimane', 'Still', 'M\'Rara'],
            
            // Wilaya 58 - El Menia (formerly part of Ghardaïa)
            '58' => ['El Meniaa', 'Hassi Gara', 'Hassi Fehal', 'Mansoura'],
        ];

        foreach ($communes as $wilayaCode => $communeNames) {
            $wilaya = Wilaya::where('code', $wilayaCode)->first();
            
            if ($wilaya) {
                foreach ($communeNames as $communeName) {
                    Commune::create([
                        'name' => $communeName,
                        
                        'wilaya_id' => $wilaya->id,
                    ]);
                }
            }
        }
    }
}