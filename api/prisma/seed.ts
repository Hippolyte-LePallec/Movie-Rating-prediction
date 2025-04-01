import { PrismaClient } from '@prisma/client'

const prisma = new PrismaClient()

async function main() {
  try {
    // Nettoyage de la base de données
    await prisma.ecrivain.deleteMany()
    await prisma.directeur.deleteMany()
    await prisma.crew.deleteMany()
    await prisma.connuPour.deleteMany()
    await prisma.principal.deleteMany()
    await prisma.mediaGenre.deleteMany()
    await prisma.mediaCategorie.deleteMany()
    await prisma.episode.deleteMany()
    await prisma.rating.deleteMany()
    await prisma.aka.deleteMany()
    await prisma.media.deleteMany()
    await prisma.personne.deleteMany()
    await prisma.genre.deleteMany()
    await prisma.categorie.deleteMany()

    // Réinitialisation des séquences SQLite
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Categorie'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Genre'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Personne'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Media'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Rating'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Aka'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Crew'`
    await prisma.$executeRaw`DELETE FROM sqlite_sequence WHERE name = 'Episode'`

    console.log('Nettoyage terminé')

    // 1. Création des catégories
    const categories = await Promise.all([
      prisma.categorie.create({
        data: { nom_categorie: 'Film' }
      }),
      prisma.categorie.create({
        data: { nom_categorie: 'Série TV' }
      }),
      prisma.categorie.create({
        data: { nom_categorie: 'Documentaire' }
      })
    ])
    
    const filmCategorie = categories[0]
    const serieCategorie = categories[1]
    const documentaireCategorie = categories[2]
    
    console.log('Catégories créées:', categories.map(c => c.nom_categorie))

    // 2. Création des genres
    const genres = await Promise.all([
      prisma.genre.create({
        data: { nom_genre: 'Action' }
      }),
      prisma.genre.create({
        data: { nom_genre: 'Comédie' }
      }),
      prisma.genre.create({
        data: { nom_genre: 'Drame' }
      }),
      prisma.genre.create({
        data: { nom_genre: 'Science-Fiction' }
      })
    ])
    
    const actionGenre = genres[0]
    const comedieGenre = genres[1]
    const dramaGenre = genres[2]
    const sciFiGenre = genres[3]
    
    console.log('Genres créés:', genres.map(g => g.nom_genre))

    // 3. Création des personnes
    const personnes = await Promise.all([
      prisma.personne.create({
        data: {
          primary_name: 'Steven Spielberg',
          birth_year: 1946,
          profession: 'Réalisateur, Producteur, Scénariste'
        }
      }),
      prisma.personne.create({
        data: {
          primary_name: 'Tom Hanks',
          birth_year: 1956,
          profession: 'Acteur, Producteur'
        }
      }),
      prisma.personne.create({
        data: {
          primary_name: 'Christopher Nolan',
          birth_year: 1970,
          profession: 'Réalisateur, Scénariste, Producteur'
        }
      }),
      prisma.personne.create({
        data: {
          primary_name: 'Scarlett Johansson',
          birth_year: 1984,
          profession: 'Actrice'
        }
      })
    ])
    
    const spielberg = personnes[0]
    const hanks = personnes[1]
    const nolan = personnes[2]
    const johansson = personnes[3]
    
    console.log('Personnes créées:', personnes.map(p => p.primary_name))

    // 4. Création des médias
    const inception = await prisma.media.create({
      data: {
        titleType: 'movie',
        primaryTitle: 'Inception',
        originalTitle: 'Inception',
        isAdult: false,
        startYear: 2010,
        runtimeMinutes: 148,
      }
    })

    const savingPrivateRyan = await prisma.media.create({
      data: {
        titleType: 'movie',
        primaryTitle: 'Il faut sauver le soldat Ryan',
        originalTitle: 'Saving Private Ryan',
        isAdult: false,
        startYear: 1998,
        runtimeMinutes: 169,
      }
    })

    const breakingBad = await prisma.media.create({
      data: {
        titleType: 'tvSeries',
        primaryTitle: 'Breaking Bad',
        originalTitle: 'Breaking Bad',
        isAdult: false,
        startYear: 2008,
        endYear: 2013,
        runtimeMinutes: 45,
      }
    })
    
    console.log('Médias créés')

    // 5. Création des crews
    const inceptionCrew = await prisma.crew.create({ data: {} })
    const savingPrivateRyanCrew = await prisma.crew.create({ data: {} })

    // 6. Association des catégories aux médias
    await prisma.mediaCategorie.create({
      data: {
        mediaId: inception.id_media,
        categorieId: filmCategorie.id_categorie
      }
    })

    await prisma.mediaCategorie.create({
      data: {
        mediaId: savingPrivateRyan.id_media,
        categorieId: filmCategorie.id_categorie
      }
    })

    await prisma.mediaCategorie.create({
      data: {
        mediaId: breakingBad.id_media,
        categorieId: serieCategorie.id_categorie
      }
    })
    
    console.log('Associations médias-catégories créées')

    // 7. Association des genres aux médias
    await Promise.all([
      // Inception: Action + SciFi
      prisma.mediaGenre.create({
        data: {
          mediaId: inception.id_media,
          genreId: actionGenre.id_genre
        }
      }),
      prisma.mediaGenre.create({
        data: {
          mediaId: inception.id_media,
          genreId: sciFiGenre.id_genre
        }
      }),
      
      // Saving Private Ryan: Action + Drama
      prisma.mediaGenre.create({
        data: {
          mediaId: savingPrivateRyan.id_media,
          genreId: actionGenre.id_genre
        }
      }),
      prisma.mediaGenre.create({
        data: {
          mediaId: savingPrivateRyan.id_media,
          genreId: dramaGenre.id_genre
        }
      }),
      
      // Breaking Bad: Drama
      prisma.mediaGenre.create({
        data: {
          mediaId: breakingBad.id_media,
          genreId: dramaGenre.id_genre
        }
      })
    ])
    
    console.log('Associations médias-genres créées')

    // 8. Création des ratings
    await Promise.all([
      prisma.rating.create({
        data: {
          averageRating: 8.8,
          numVotes: 2200000,
          mediaId: inception.id_media
        }
      }),
      prisma.rating.create({
        data: {
          averageRating: 8.6,
          numVotes: 1300000,
          mediaId: savingPrivateRyan.id_media
        }
      }),
      prisma.rating.create({
        data: {
          averageRating: 9.5,
          numVotes: 1700000,
          mediaId: breakingBad.id_media
        }
      })
    ])
    
    console.log('Ratings créés')

    // 9. Création des titres alternatifs (Aka)
    await Promise.all([
      prisma.aka.create({
        data: {
          ordering: 1,
          title: 'Origem',
          region: 'BR',
          language: 'pt',
          isOriginalTitle: false,
          mediaId: inception.id_media
        }
      }),
      prisma.aka.create({
        data: {
          ordering: 2,
          title: 'Начало',
          region: 'RU',
          language: 'ru',
          isOriginalTitle: false,
          mediaId: inception.id_media
        }
      }),
      prisma.aka.create({
        data: {
          ordering: 1,
          title: 'Saving Private Ryan',
          region: 'FR',
          language: 'en',
          isOriginalTitle: true,
          mediaId: savingPrivateRyan.id_media
        }
      })
    ])
    
    console.log('Titres alternatifs créés')

    // 10. Création des épisodes
    await Promise.all([
      prisma.episode.create({
        data: {
          seasonNumber: 1,
          episodeNumber: 1,
          parentTconst: 'tt0903747',
          mediaId: breakingBad.id_media
        }
      }),
      prisma.episode.create({
        data: {
          seasonNumber: 1,
          episodeNumber: 2,
          parentTconst: 'tt0903747',
          mediaId: breakingBad.id_media
        }
      }),
      prisma.episode.create({
        data: {
          seasonNumber: 5,
          episodeNumber: 14,
          parentTconst: 'tt0903747',
          mediaId: breakingBad.id_media
        }
      })
    ])
    
    console.log('Épisodes créés')

    // 11. Création des principaux
    await Promise.all([
      prisma.principal.create({
        data: {
          ordering: 1,
          job: 'Director',
          mediaId: inception.id_media,
          personneId: nolan.id_name
        }
      }),
      prisma.principal.create({
        data: {
          ordering: 1,
          job: 'Director',
          mediaId: savingPrivateRyan.id_media,
          personneId: spielberg.id_name
        }
      }),
      prisma.principal.create({
        data: {
          ordering: 2,
          job: 'Actor',
          characters: 'Captain Miller',
          mediaId: savingPrivateRyan.id_media,
          personneId: hanks.id_name
        }
      }),
      prisma.principal.create({
        data: {
          ordering: 3,
          job: 'Actress',
          characters: 'Black Widow',
          mediaId: inception.id_media,
          personneId: johansson.id_name
        }
      })
    ])
    
    console.log('Principaux créés')

    // 12. Création des directeurs
    await Promise.all([
      prisma.directeur.create({
        data: {
          crewId: inceptionCrew.id_crew,
          personneId: nolan.id_name
        }
      }),
      prisma.directeur.create({
        data: {
          crewId: savingPrivateRyanCrew.id_crew,
          personneId: spielberg.id_name
        }
      })
    ])
    
    console.log('Directeurs créés')

    // 13. Création des écrivains
    await prisma.ecrivain.create({
      data: {
        crewId: inceptionCrew.id_crew,
        personneId: nolan.id_name
      }
    })
    
    console.log('Écrivains créés')

    // 14. Création des "connu pour"
    await Promise.all([
      prisma.connuPour.create({
        data: {
          mediaId: inception.id_media,
          personneId: nolan.id_name
        }
      }),
      prisma.connuPour.create({
        data: {
          mediaId: savingPrivateRyan.id_media,
          personneId: spielberg.id_name
        }
      }),
      prisma.connuPour.create({
        data: {
          mediaId: savingPrivateRyan.id_media,
          personneId: hanks.id_name
        }
      })
    ])
    
    console.log('Relations "connu pour" créées')

    console.log('La base de données a été initialisée avec succès.')
  } catch (error) {
    console.error('Erreur lors de l\'initialisation :', error)
  }
}

main()
  .catch((e) => {
    console.error('Erreur non gérée :', e)
    throw e
  })
  .finally(async () => {
    await prisma.$disconnect()
  })