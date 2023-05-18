
public abstract class Operation {
	
	/*
	 * la classe Operation a des 2 objets de type Nombre
	 * J'ai créé 2 constructeurs pour permettre à l'utilisateur 
	 * d'instancier la classe qui va hériter de la classe Operation
	 * soit avec des objets de type Nombre 
	 * soit avec des nombres de types entiers
	 */
	
	private Nombre nombre1;
	
	private Nombre nombre2;
	
	/*
	 * constructeur champ à champ
	 * Il prends en paramètres 2 objets de type Nombre
	 * Il permet d'instancier la classe avec des objets de type Nombre
	 */
	
	
	public Operation(Nombre objet_nombre1,Nombre objet_nombre2) {
		this.nombre1 = objet_nombre1;
		this.nombre2 = objet_nombre2;
	}
	
	/*
	 * constructeur par copie 
	 * Il permet d'instancier la classe avec des nombres de type int
	 qui vont après instancier la classe Nombre 
	 */
	
	public Operation(int nombre1, int nombre2) {
		this.nombre1  = new Nombre (nombre1);
		this.nombre2 = new Nombre(nombre2);
	}
	
	
	/*
	* le getter retourne le 1er nombre
	*/
	public int getNombre1() {
		return this.nombre1.getValeurNombre();
	}
	/*
	* elle retourne le 2ème nombre
	*/
	
	public int getNombre2() {
		return this.nombre2.getValeurNombre();
	}
	
	/*
	cette méthode 'setter' permet de changer la valeur du nombre
	*/
	public void setNombre1(int nombre1) {
		this.nombre1.setValeurNombre(nombre1);
	}
	
	public void setNombre2(int nombre2) {
		this.nombre2.setValeurNombre(nombre2);
	}
	
	
	/*
	* cette méthode retourne le premier objet de type Nombre
	*/
	
	public Nombre getOperande1() {
		return this.nombre1;
	}
	
	public Nombre getOperande2() {
		return this.nombre2;
	}
	
	/*
	 * La méthode valeur() est abstraite
	 * elle n'a que la signature 
	 * elle va être redéfinie dans les classes qui vont hériter
	 */
	public abstract int valeur();
	
}
