package IPI.mindle.mindleBack;

import IPI.mindle.mindleBack.entity.sousGenres;
import IPI.mindle.mindleBack.entity.listGenres;
import net.ravendb.client.documents.DocumentStore;
import net.ravendb.client.documents.IDocumentStore;
import net.ravendb.client.documents.conventions.DocumentConventions;
import net.ravendb.client.documents.session.IDocumentSession;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;


public class MindleBackApplication {

	static final String URL = "http://localhost:8080";
	static final String DATABASE = "Mindle";

	static IDocumentStore store;
	static IDocumentSession session;
	static IDocumentSession session2;


	static listGenres genresList;

	public static void main(String[] args) {
		store = CreateStore();
		session = store.openSession();
		genresList = session.load(listGenres.class, "bfd0f09a-2172-4153-97e5-0f549c413fe2");
		CreateNewUser("modelNewUser", genresList);
		//AddDataUsers("Bossanova");
		//GetMainGenres();
	}

	public static IDocumentStore CreateStore() {
		store = new DocumentStore(new String[]{URL}, DATABASE);
		store.initialize();
		return store;
	}


	//Ajout d'informations utilisateurs
	//Gestion des totaux des sous genres et genres principaux
	public static void AddDataUsers(String NewGenres){
		List<String> mainGenres = null;
		for (sousGenres sousGenre: genresList.listGenres) {
			if(sousGenre.Name.equals(NewGenres)){
				sousGenre.Total = sousGenre.Total + 1;
				mainGenres = sousGenre.Genre;
				}
			}
		if (mainGenres != null){
			for (sousGenres sousGenre: genresList.listGenres) {
				for (String mainGenre : mainGenres){
					if (mainGenre.equals(sousGenre.Name)){
						sousGenre.Total = sousGenre.Total + 1;
					}
				}
			}
		}
		session.saveChanges();
	}

	//Récupération des Genres principaux
	public static void GetMainGenres(){
		ArrayList<ArrayList<String>> Totals = new ArrayList();
		List<String> listMainGenres = Arrays.asList("Jazz", "Rock");
		for (String MainGenre : listMainGenres) {
			for (sousGenres sousGenre: genresList.listGenres) {
				if (sousGenre.Name.equals(MainGenre)){
					ArrayList<String> Provisoire = new ArrayList();
					Provisoire.add(sousGenre.Name);
					Provisoire.add(sousGenre.Total.toString());
					Totals.add(Provisoire);
				}
			}
		}
	}


	//Création d'un nouveau doc utilisateur
	//L'id correspondra à son idSpotify
	public static void CreateNewUser(String id, listGenres NewUser){
		session2 = store.openSession();
		session2.store(NewUser, id);
		session2.saveChanges();
	}

}
