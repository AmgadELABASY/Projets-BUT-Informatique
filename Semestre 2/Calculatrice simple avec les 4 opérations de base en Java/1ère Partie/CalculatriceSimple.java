
public class CalculatriceSimple {

	public static void main(String[] args){
		
		Nombre six = new Nombre(6);
		
		Nombre dix = new Nombre(10);
		
		
		Operation add = new Addition(six,dix);
		
		System.out.println(add + " = " + add.valeur()) ;
		
		System.out.println("--------------------------------------------------");
		
		
		Operation s = new Soustraction(dix,six) ;
		System.out.println(s + " = " + s.valeur()) ;
		System.out.println("--------------------------------------------------");
		
		Operation m = new Multiplication(6,10);
		System.out.println(m+" = "+m.valeur());
		
		System.out.println("--------------------------------------------------");
		
		try {
			Operation div = new Division(8,0);
			System.out.println(div+" = "+div.valeur());
		}
		catch(ArithmeticException a) {
			System.out.println("Il y a eu une erreur, ce n'est pas possible de diviser par 0 ");
			a.printStackTrace();
			
		}
		
		System.out.println("Tout se passe bien ");
		
		Nombre cent = new Nombre(100);
		Division d = new Division(cent,dix);
		System.out.println(d+" = "+d.valeur());
	}

}








