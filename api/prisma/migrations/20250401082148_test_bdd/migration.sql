-- CreateTable
CREATE TABLE "Aka" (
    "id_aka" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "ordering" INTEGER NOT NULL,
    "title" TEXT NOT NULL,
    "region" TEXT,
    "language" TEXT,
    "types" TEXT,
    "attributes" TEXT,
    "isOriginalTitle" BOOLEAN NOT NULL DEFAULT false,
    "mediaId" INTEGER NOT NULL,
    CONSTRAINT "Aka_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE RESTRICT ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Rating" (
    "id_rating" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "averageRating" REAL NOT NULL,
    "numVotes" INTEGER NOT NULL,
    "mediaId" INTEGER,
    CONSTRAINT "Rating_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE SET NULL ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Episode" (
    "id_episode" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "parentTconst" TEXT,
    "seasonNumber" INTEGER,
    "episodeNumber" INTEGER,
    "mediaId" INTEGER,
    CONSTRAINT "Episode_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE SET NULL ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Media" (
    "id_media" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "titleType" TEXT NOT NULL,
    "primaryTitle" TEXT NOT NULL,
    "originalTitle" TEXT,
    "isAdult" BOOLEAN NOT NULL DEFAULT false,
    "startYear" INTEGER,
    "endYear" INTEGER,
    "runtimeMinutes" INTEGER
);

-- CreateTable
CREATE TABLE "Categorie" (
    "id_categorie" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "nom_categorie" TEXT NOT NULL
);

-- CreateTable
CREATE TABLE "MediaCategorie" (
    "mediaId" INTEGER NOT NULL,
    "categorieId" INTEGER NOT NULL,

    PRIMARY KEY ("mediaId", "categorieId"),
    CONSTRAINT "MediaCategorie_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT "MediaCategorie_categorieId_fkey" FOREIGN KEY ("categorieId") REFERENCES "Categorie" ("id_categorie") ON DELETE RESTRICT ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Genre" (
    "id_genre" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "nom_genre" TEXT NOT NULL
);

-- CreateTable
CREATE TABLE "MediaGenre" (
    "mediaId" INTEGER NOT NULL,
    "genreId" INTEGER NOT NULL,

    PRIMARY KEY ("mediaId", "genreId"),
    CONSTRAINT "MediaGenre_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT "MediaGenre_genreId_fkey" FOREIGN KEY ("genreId") REFERENCES "Genre" ("id_genre") ON DELETE RESTRICT ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Personne" (
    "id_name" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    "primary_name" TEXT NOT NULL,
    "birth_year" INTEGER,
    "death_year" INTEGER,
    "profession" TEXT
);

-- CreateTable
CREATE TABLE "Principal" (
    "ordering" INTEGER NOT NULL,
    "job" TEXT,
    "characters" TEXT,
    "mediaId" INTEGER NOT NULL,
    "personneId" INTEGER NOT NULL,

    PRIMARY KEY ("mediaId", "personneId"),
    CONSTRAINT "Principal_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT "Principal_personneId_fkey" FOREIGN KEY ("personneId") REFERENCES "Personne" ("id_name") ON DELETE RESTRICT ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "ConnuPour" (
    "mediaId" INTEGER NOT NULL,
    "personneId" INTEGER NOT NULL,

    PRIMARY KEY ("mediaId", "personneId"),
    CONSTRAINT "ConnuPour_mediaId_fkey" FOREIGN KEY ("mediaId") REFERENCES "Media" ("id_media") ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT "ConnuPour_personneId_fkey" FOREIGN KEY ("personneId") REFERENCES "Personne" ("id_name") ON DELETE RESTRICT ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Crew" (
    "id_crew" INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT
);

-- CreateTable
CREATE TABLE "Directeur" (
    "crewId" INTEGER NOT NULL,
    "personneId" INTEGER NOT NULL,

    PRIMARY KEY ("crewId", "personneId"),
    CONSTRAINT "Directeur_crewId_fkey" FOREIGN KEY ("crewId") REFERENCES "Crew" ("id_crew") ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT "Directeur_personneId_fkey" FOREIGN KEY ("personneId") REFERENCES "Personne" ("id_name") ON DELETE RESTRICT ON UPDATE CASCADE
);

-- CreateTable
CREATE TABLE "Ecrivain" (
    "crewId" INTEGER NOT NULL,
    "personneId" INTEGER NOT NULL,

    PRIMARY KEY ("crewId", "personneId"),
    CONSTRAINT "Ecrivain_crewId_fkey" FOREIGN KEY ("crewId") REFERENCES "Crew" ("id_crew") ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT "Ecrivain_personneId_fkey" FOREIGN KEY ("personneId") REFERENCES "Personne" ("id_name") ON DELETE RESTRICT ON UPDATE CASCADE
);
