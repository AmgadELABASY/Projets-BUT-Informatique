
public class Nombre {
	
	
	/*
	 * variable d'instance
	 */
	private int valeurNombre;
	
	/*
	 * constructeur par défaut
	 *
	 */
	
	public Nombre() {
		this.valeurNombre = 0;
	}
	
	/*
	 * Constructeur champ à champ qui permet d'instancier la classe Nombre
	 */
	
	public Nombre(int nombre) {
		this.valeurNombre = nombre;
	}
	
	/*
	 * constructeur par copie
	 */
	public Nombre(Nombre n) {
		this.valeurNombre = n.getValeurNombre();
	}
	
	
	/*
	 * getter
	 */
	public int getValeurNombre() {
		return this.valeurNombre;
	}
	
	
	/*
	 * setter 
	 */
	public void setValeurNombre(int nombre) {
		this.valeurNombre = nombre;
	}
	
	/*
	 * La méthode valeur() représente la valeur du nombre 
	 */
	
	public int valeur() {
		return this.valeurNombre;
	}
	
	/*
	 * toString
	 */
	
	public String toString() {
		String c = ""+this.valeurNombre;
		return c;
	}
}












