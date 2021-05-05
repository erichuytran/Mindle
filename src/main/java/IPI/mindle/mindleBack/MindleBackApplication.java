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
	static final String DATABASE = "testmindle";

	static IDocumentStore store;
	static IDocumentSession session;

	static listGenres genresList;

	public static void main(String[] args) {
		store = CreateStore();
		session = store.openSession();
		SpringApplication.run(MindleBackApplication.class, args);
		genresList = session.load(listGenres.class, "1a891a7e-c074-4670-9d34-0dd4fa82c67c");
		System.out.println("la liste contient : " + genresList.listGenres.size() + "genres");
		//AddDataUsers("Bosanova");
		GetMainGenres();
	}

	public static IDocumentStore CreateStore() {
		store = new DocumentStore(new String[]{URL}, DATABASE);
		DocumentConventions conventions = store.getConventions();
		store.initialize();
		return store;
	}

	public static void AddDataUsers(String NewGenres){
		List<String> mainGenres = null;
		for (sousGenres sousGenre: genresList.listGenres) {
			/*System.out.println(sousGenre.Name);
			System.out.println(sousGenre.Total);
			System.out.println(sousGenre.Genre);*/
			if(sousGenre.Name.equals(NewGenres)){
				System.out.println("oui");
				sousGenre.Total = sousGenre.Total + 1;
				mainGenres = sousGenre.Genre;
				System.out.println(mainGenres);
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

	public static void GetMainGenres(){
		ArrayList<ArrayList<String>> Totals = new ArrayList();
		List<String> listMainGenres = Arrays.asList("Jazz", "rnb");
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
		System.out.println(Totals);
	}

}
