```bash
apt install git apache2-dev build-essential libmaxminddb-dev
cd /usr/local/src/
git clone https://github.com/maxmind/mod_maxminddb.git
cd mod_maxminddb
./bootstrap
./configure
make
make install
```

```bash
/etc/apache2/mods-enabled/maxminddb.conf:

MaxMindDBEnable On
MaxMindDBFile MM_COUNTRY_DB /usr/local/share/maxminddb/GeoLite2-Country.mmdb
MaxMindDBFile MM_CITY_DB /usr/local/share/maxminddb/GeoLite2-City.mmdb
MaxMindDBFile MM_ASN_DB /usr/local/share/maxminddb/GeoLite2-ASN.mmdb


MaxMindDBEnv MM_COUNTRY_CODE_COUNTRY_DB MM_COUNTRY_DB/country/iso_code
MaxMindDBNetworkEnv MM_COUNTRY_DB MM_COUNTRY_NETWORK


MaxMindDBEnv MM_COUNTRY_CODE_CITY_DB MM_CITY_DB/country/iso_code
MaxMindDBEnv MM_COUNTRY_NAME MM_CITY_DB/country/names/de
MaxMindDBEnv MM_CITY_NAME MM_CITY_DB/city/names/de
MaxMindDBEnv MM_REGION_CODE  MM_CITY_DB/subdivisions/0/iso_code
MaxMindDBEnv MM_LONGITUDE MM_CITY_DB/location/longitude
MaxMindDBEnv MM_LATITUDE MM_CITY_DB/location/latitude
MaxMindDBNetworkEnv MM_CITY_DB MM_CITY_DB_NETWORK


MaxMindDBEnv MM_ASN MM_ASN_DB/autonomous_system_number
MaxMindDBEnv MM_AS_ORG MM_ASN_DB/autonomous_system_organization
MaxMindDBNetworkEnv MM_ASN_DB MM_ASN_DB_NETWORK
```