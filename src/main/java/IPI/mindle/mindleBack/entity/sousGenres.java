package IPI.mindle.mindleBack.entity;

import java.util.List;

public class sousGenres {

    public String Name ;
    public Integer Total;
    public List<String> Genre;

    public String getName() {
        return Name;
    }

    public void setName(String name) {
        Name = name;
    }

    public Integer getTotal() {
        return Total;
    }

    public void setTotal(Integer total) {
        Total = total;
    }

    public List<String> getGenre() {
        return Genre;
    }

    public void setGenre(List<String> genre) {
        Genre = genre;
    }
}
