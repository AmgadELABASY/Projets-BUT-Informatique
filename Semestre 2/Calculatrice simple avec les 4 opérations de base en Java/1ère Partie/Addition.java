
public class Addition extends Operation {

	/*
	* cette classe hérite les attributs et les méthodes de la classe Operation 
	*/

	/*
	* ce constructeur permet d'instancier la classe Addition avec des nombres
	*/
	public Addition(int nombre1, int nombre2) {
		super(nombre1, nombre2);
		
	}

	/*
	* ce constructeur permet d'instancier la classe avec des objets de type Nombre
	*/
	public Addition(Nombre objet_nombre1,Nombre objet_nombre2) {
		super(objet_nombre1,objet_nombre2);
	}

	/*
	* la méthode valeur héritée de la classe Operation est implémentée ici
	*/
	@Override
	public int valeur() {
		
		return super.getNombre1() + super.getNombre2();
		
	}
	public String toString() {
		return this.getNombre1() + " + " + this.getNombre2();
	}

}
