
public class Soustraction extends Operation {

	public Soustraction(int nombre1, int nombre2) {
		super(nombre1, nombre2);
		
	}
	
	public Soustraction(Nombre objet_nombre1,Nombre objet_nombre2) {
		super(objet_nombre1,objet_nombre2);
	}

	@Override
	public int valeur() {
		
		return super.getNombre1() - super.getNombre2();
	}
	
	public String toString() {
		return this.getNombre1() + " - " + this.getNombre2();
	}

}
