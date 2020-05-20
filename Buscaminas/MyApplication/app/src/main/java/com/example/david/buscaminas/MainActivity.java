package com.example.david.buscaminas;

import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.ActivityInfo;
import android.graphics.Color;
import android.graphics.Point;
import android.os.Build;
import android.os.SystemClock;
import android.preference.PreferenceManager;
import android.support.annotation.RequiresApi;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Display;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.Chronometer;
import android.widget.GridLayout;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import static java.lang.StrictMath.max;

public class MainActivity extends AppCompatActivity implements DialogoPersonaje.respuestaDialogoPersonaje,DialogoDerrota.RespuestaDialogoDerrota,DialogoDificultad.RespuestaDialogoOpciones, DialogoVictoria.RespuestaVictoria, DialogoNoMina.RespuestaDialogoMina{


    int tablero[][];
    Chronometer cronometro;
    TextView textoBombas;
    Button botonReinicio;
    // Declaramos un objeto SharedPreferences:
   // SharedPreferences preferences= PreferenceManager.getDefaultSharedPreferences(this);
    //SharedPreferences.Editor editor = preferences.edit();
    public SharedPreferences preferences;


    @RequiresApi(api = Build.VERSION_CODES.JELLY_BEAN_MR1)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_PORTRAIT);
        // Identificamos los elementos del menú de informaciónd e juego:
        cronometro = (Chronometer)findViewById(R.id.tiempo);
        textoBombas = (TextView)findViewById(R.id.numBombas);
        botonReinicio =(Button)findViewById(R.id.reiniciar);
        botonReinicio.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Al pusar en el botón de juego reiniciamos la partida:
                reiniciarJuego();


            }
        });
        // Establecemos el tiempo del cronometro y lo iniciamos:
        cronometro.setBase(SystemClock.elapsedRealtime());
        cronometro.start();
        Display display = getWindowManager().getDefaultDisplay();
        preferences= PreferenceManager.getDefaultSharedPreferences(this);
        /////////////////////////////////////////////////////////////////

        String dificultad = preferences.getString("Dificultad", "0");
        //Toast.makeText(getApplicationContext(),"P:"+name,Toast.LENGTH_LONG ).show();


        // Tamaño en píxeles
        Point size = new Point();
        display.getSize(size);
        int width = size.x;
        int height = size.y;

        int numCeldas=8;
        int numBombas=10;

        if (dificultad.equals("0")){

            numCeldas=8;
            numBombas=10;

        }

        if (dificultad.equals("1")){

            numCeldas=12;
            numBombas=30;

        }
        if (dificultad.equals("2")){

            numCeldas=16;
            numBombas=60;

        }

        // Añadimos el número de bombas:
        textoBombas.setText(""+numBombas);
        tablero=new int [numCeldas][numCeldas];


        //Ponemos 0 en todas las posiciones
        for (int i = 0; i < numCeldas; i++)		// El primer índice recorre las filas.
            for (int j = 0; j < numCeldas; j++){	// El segundo índice recorre las columnas.
                // Procesamos cada elemento de la matriz.
                //System.out.println(tablero[i][j]);
                tablero[i][j]=0;

            }




        //Pone las minas
        for (int mina=0;mina<numBombas;mina++){
            //Busca una posición aleatoria donde no haya otra bomba
            int f,c;
            do{
                f=(int)(Math.random()*numCeldas);
                c=(int)(Math.random()*numCeldas);
            }while(tablero[f][c]==-1);
            //Pone la bomba
            tablero[f][c]=-1;

        }



        //se ponen los 1, 2, 3....
        for (int i = 0; i < numCeldas; i++){ //I recorre las filas

            for (int j = 0; j < numCeldas; j++){	// El segundo índice recorre las columnas.

                //se verifica que en esa posicion hay una mina
                if(tablero[i][j]==-1){

                    //se miran las 8 posiciones adyacentes, que no tengan otra mina y que existan
                    //si se cumplen las condiciones anteriores se suma un 1


                    if(i-1>=0 && tablero[i-1][j]!=-1){  //
                        tablero[i-1][j]= tablero[i-1][j]+1;
                    }

                    if(j-1>=0 && tablero[i][j-1]!=-1){
                        tablero[i][j-1]=tablero[i][j-1]+1;
                    }

                    if(i-1>=0 && j-1>=0 && tablero[i-1][j-1]!=-1){
                        tablero[i-1][j-1]= tablero[i-1][j-1]+1;
                    }

                    if(i+1<numCeldas && tablero[i+1][j]!=-1){
                        tablero[i+1][j]=tablero[i+1][j]+1;
                    }

                    if(j+1<numCeldas && tablero[i][j+1]!=-1){
                        tablero[i][j+1]=tablero[i][j+1]+1;
                    }

                    if(i+1<numCeldas && j+1<numCeldas && tablero[i+1][j+1]!=-1){
                        tablero[i+1][j+1]=tablero[i+1][j+1]+1;
                    }

                    if(i-1>=0 && j+1<numCeldas && tablero[i-1][j+1]!=-1){
                        tablero[i-1][j+1]=tablero[i-1][j+1]+1;
                    }

                    if(i+1<numCeldas && j-1>=0 && tablero[i+1][j-1]!=-1){
                        tablero[i+1][j-1]=tablero[i+1][j-1]+1;
                    }

                }


            }
        }

        //se ejecuta el metodo que crea el tablero
        añadeBotones(numCeldas);



    }


    // AppCompatActivity incluye este método para agregar las aopciones del menú al toolbar:
    public boolean onCreateOptionsMenu(Menu menu){
        // Hacemos referencia al menu creado para la toolbar y añadimos los elementos:
        getMenuInflater().inflate(R.menu.menu,menu);
        return true;


    }

    // AppCompatActivity incluye este método para capturar la acción al seleccionar un elemento del menú del toolbar(Recibe un item del menu):
    public boolean onOptionsItemSelected(MenuItem item){
        // Creamos uan estructura de control para ver la opción selecciona:
        switch (item.getItemId()){

            case R.id.dificultad:
               DialogoDificultad ds=new DialogoDificultad();

                //Cogemos la dificultad y se la pasamos al menu de opciones
                preferences= PreferenceManager.getDefaultSharedPreferences(this);
                String dificultad = preferences.getString("Dificultad", "0");

                ds.dameDificultad(dificultad);
                //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                //obtenemos con la función getSupportFragmentManager() y una etiqueta con el texto
                //identificador del diálogo
                ds.show(getFragmentManager(), "Dificultad");

                break;
            case R.id.personaje:
                DialogoPersonaje dp=new DialogoPersonaje();

                preferences= PreferenceManager.getDefaultSharedPreferences(this);
                String personaje= preferences.getString("Personaje", "0");

                dp.damePersonaje(personaje);
                //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                //obtenemos con la función getSupportFragmentManager() y una etiqueta con el texto
                //identificador del diálogo
                dp.show(getFragmentManager(), "Dificultad");

                break;
            case R.id.salir:
                // Con esta opción finalizamos la aplicación:
                //finalizamos la actividad actual
                this.finish();
                break;
            default:
                break;

        }

        return true;
    }


    //Funciones para abreviar letras.
    public int max(int a, int b){
        return Math.max(a,b);
    }
    public int min(int a, int b){
        return Math.min(a,b);
    }




    @RequiresApi(api = Build.VERSION_CODES.JELLY_BEAN_MR1)
    public void añadeBotones(int Celdas){

        //Calcular el tamaño de la pantalla
        Display display = getWindowManager().getDefaultDisplay();
        Point size = new Point();
        display.getSize(size);
        int width = size.x;
        int height = size.y;


        final int numCeldas=Celdas;

        final int[] bombasporDescubrir = {0};


        if (Celdas==8){

            bombasporDescubrir[0]=10;

        }

        if (Celdas==12){

            bombasporDescubrir[0]=30;

        }
        if (Celdas==16){

            bombasporDescubrir[0]=60;

        }



//Crea la grid dinámicamente
        GridLayout g=new GridLayout(getApplicationContext());

        //GridLayout g= (GridLayout)findViewById(R.id.layout_secundario);
        RelativeLayout r=(RelativeLayout)findViewById(R.id.general);




//parámetros para la grid
        GridLayout.LayoutParams param=new GridLayout.LayoutParams();
        param.setMargins(0,0,0,0);
        param.height= ViewGroup.LayoutParams.MATCH_PARENT;
        param.width= ViewGroup.LayoutParams.MATCH_PARENT;
        //layoutParams.setMargins(0,0,0,0); g.setRowCount(f);
        g.setColumnCount(numCeldas);
        g.setLayoutParams(param);

        g.setBackgroundColor(11111);

        //se añade el gridlayout al relativelayout
        r.addView(g);

    //parámetros para los botones
        LinearLayout.LayoutParams layoutParams = new LinearLayout.LayoutParams((width-(2*numCeldas))/numCeldas, (width-(2*numCeldas))/numCeldas);
        layoutParams.setMargins(1,1,1,1);


        g.setRowCount(numCeldas);

        Button b;
        ImageButton ib;


        for (int i = 0; i < numCeldas; i++) {    // El primer índice recorre las filas.
            for (int j = 0; j < numCeldas; j++) {    // El segundo índice recorre las columnas.

                //Si no es una bomba, creamos un boton normal
                if(tablero[i][j]!=-1){

                    b = new Button(this);
                    //se le añade las caracteristicas al boton
                    b.setLayoutParams(layoutParams);


                    b.setId(Integer.parseInt(String.valueOf(i)+00+String.valueOf(j)));

                    b.setText(String.valueOf(tablero[i][j]));
                    b.setTextColor(Color.rgb(1111, 1111, 1111));

                    //ñapa para guardas la posicion del boton en la matriz
                    //b.setScrollX(i); //filas
                    //b.setScrollY(j); //columnas

                    b.setMinWidth(i);
                    b.setMinHeight(j);


                    //b.setPadding(height, height, height, height);

                    b.setPaddingRelative(1, 1, 1, 1);


                    b.setBackgroundColor(Color.rgb(1111, 1111, 1111));

                    //se añade el boton al gridlayout
                    g.addView(b);

                    final Button finalB = b;

                    final int fila=i;
                    final int columna=j;

                    //Se establece un listener al clickar el botón
                    b.setOnClickListener((new View.OnClickListener() {//Método que se ejecuta cuando se presiona el botón sin mina
                    public void onClick(View v) {

                       //con ésto se muestra el número de esa casilla
                        //con ésto se muestra el número de esa casilla
                        descubreBotones(finalB.getId());

                        if(finalB.getText().equals("0")){

                            //Ñapa para pasar le posicion del boton en la matriz al método que descubre los 0
                           descubreCeros(fila,columna);


                        }



                    }
                    }));

                    //listener para el long click

                    b.setOnLongClickListener((new View.OnLongClickListener(){
                        @Override
                        public boolean onLongClick(View v) { //metodo del long click al presionar un boton que no se bomba

                            //con ésto se muestra el número de esa casilla
                            descubreBotones(finalB.getId());


                            // Paramos el cronometro:
                            cronometro.stop();
                            // Informamos del tiempo total de juego:
                            Toast.makeText(getApplicationContext(),"Tiempo de juego:"+cronometro.getText(),Toast.LENGTH_LONG ).show();
                            DialogoNoMina dn=new DialogoNoMina();
                            //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                            //obtenemos con la función getFragmentManager() y una etiqueta con el texto
                            //identificador del diálogo
                            //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                            //obtenemos con la función getFragmentManager() y una etiqueta con el texto
                            //identificador del diálogo
                            dn.setCancelable(false);
                            dn.show(getFragmentManager(),"Mi diálogo");



                            //finalB.setEnabled(false);
                            return false;
                        }



                    }));

                //Si es una bomba, se crea un imagebutton
                }else{



                    ib = new ImageButton(this);
                    ib.setLayoutParams(layoutParams);
                    ib.setId(tablero[i][j]);


                    ib.setPadding(height, height, height, height);

                    ib.setPaddingRelative(1, 1, 1, 1);

                    ib.setBackgroundColor(Color.rgb(1111, 1111, 1111));

                    //se añade el imageboton al gridlayout
                    g.addView(ib);

                    //Se establece un listener al clickar el botón
                    final ImageButton finalIb = ib;
                    ib.setOnClickListener((new View.OnClickListener() {//Método que se ejecuta cuando se presiona el botón con mina
                        public void onClick(View v) {


                            //***************AQUI SE INSERTA LA IMAGEN DE LA BOMBA!!**************************
                            // finalIb.setImageIcon(enlace de la imagen); SE HARÁ ALGO ASI

                            finalIb.setImageResource(R.drawable.minacuatro);
                            finalIb.setBackgroundColor(Color.rgb(255, 0, 0));
                            // Paramos el cronometro:
                            cronometro.stop();
                            // Informamos del tiempo total de juego:
                            Toast.makeText(getApplicationContext(),"Tiempo de juego:"+cronometro.getText(),Toast.LENGTH_LONG ).show();
                            DialogoDerrota ds=new DialogoDerrota();
                            //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                            //obtenemos con la función getFragmentManager() y una etiqueta con el texto
                            //identificador del diálogo
                            //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                            //obtenemos con la función getFragmentManager() y una etiqueta con el texto
                            //identificador del diálogo
                            ds.setCancelable(false);
                            ds.show(getFragmentManager(),"Mi diálogo");



                        }
                    }));

                    //listener para el long click
                    ib.setOnLongClickListener((new View.OnLongClickListener(){
                        @Override
                        public boolean onLongClick(View v) { //metodo del long click al presionar un boton que es una bomba


                            //******************AQUI SE INSERTA LA IMAGEN DE LA BANDERA!!*********************
                            // finalIb.setImageIcon(enlace de la imagen); SE HARÁ ALGO ASI
                            // preferences= PreferenceManager.getDefaultSharedPreferences(this);
                            String personaje= preferences.getString("Personaje", "0");

                            // Establecemos el tipo de bandera que escoja el usuario:
                            switch(personaje){

                                case "0":

                                    finalIb.setImageResource(R.drawable.banderitauno);

                                    break;
                                case "1":

                                    finalIb.setImageResource(R.drawable.banderitados);

                                    break;
                                case "2":

                                    finalIb.setImageResource(R.drawable.banderitatres);

                                    break;
                              default:
                                  finalIb.setImageResource(R.drawable.banderitauno);
                                  break;
                            }


                            finalIb.setBackgroundColor(Color.rgb(255, 255, 255)); //con esto la casilla se pone de color blanco

                            Toast toast1 = Toast.makeText(getApplicationContext(), "Muy bien, has descubierto una mina!!", Toast.LENGTH_SHORT);

                            toast1.show();

                            ///mostramos las bombas que quedan por descubrir
                            bombasporDescubrir[0]--;

                            // Actualizamos el contador de bombas:
                            actualizaContadorBombas(textoBombas);
                            // Bloqueamos el boton para que no se pueda volver a pulsar:
                            finalIb.setEnabled(false);

                            if( bombasporDescubrir[0]==0){
                                // Paramos el cronometro:
                                cronometro.stop();
                                // Informamos del tiempo total de juego:
                                Toast.makeText(getApplicationContext(),"Tiempo de juego:"+cronometro.getText(),Toast.LENGTH_LONG ).show();
                                DialogoVictoria dv=new DialogoVictoria();
                                //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                                //obtenemos con la función getFragmentManager() y una etiqueta con el texto
                                //identificador del diálogo
                                //Al método show del diálogo le pasamos un objeto FragmentManager que lo
                                //obtenemos con la función getFragmentManager() y una etiqueta con el texto
                                //identificador del diálogo
                                dv.setCancelable(false);
                                dv.show(getFragmentManager(),"Mi diálogo");


                            }





                            return false;
                        }
                    }));

                }
            }
        }

    }


    @Override
    //Metodo para volver  a jugar o acabar
    public void onRespuesta(boolean s) {

        if(s==true){

            Intent intent=new Intent();
            intent.setClass(this, this.getClass());
            //llamamos a la actividad
            this.startActivity(intent);
            //finalizamos la actividad actual
            this.finish();


        }else{

            this.finish();


        }

    }

    @Override
    public void respuestaDificultad(int elementoSeleccionado) {

        if(elementoSeleccionado==0){


            Toast.makeText(getApplicationContext(),"Dificultad fácil seleccionada",Toast.LENGTH_LONG ).show();

        }

        if(elementoSeleccionado==1){

            Toast.makeText(getApplicationContext(),"Dificultad normal seleccionada",Toast.LENGTH_LONG ).show();


        }

        if(elementoSeleccionado==2){

            Toast.makeText(getApplicationContext(),"Dificultad dificil seleccionada",Toast.LENGTH_LONG ).show();


        }
        //Toast.makeText(getApplicationContext(),"Dificultad seleccionada:"+elementoSeleccionado,Toast.LENGTH_LONG ).show();

        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("Dificultad", String.valueOf(elementoSeleccionado));
        editor.apply();


        Intent intent=new Intent();
        intent.setClass(this, this.getClass());
        //llamamos a la actividad
        this.startActivity(intent);
        //finalizamos la actividad actual
        this.finish();
    }


    public void descubreCeros(int x, int y){

        //x son las filas
        //y son las columnas


        //se miran las 8 posiciones adyacentes, que no tengan otra mina y que existan
        //si se cumplen las condiciones anteriores se suma un 1

        if(tablero[x][y]==0){


            try{
                tablero[x][y]=20;
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x-1][y-1]==0){
                    descubreCeros(x-1,y-1);
                }else{
                    //tablero[x-1][y-1]=8;

                    int dato=Integer.parseInt( String.valueOf(x-1)+00+String.valueOf(y-1));
                    descubreBotones(dato);


                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x][y-1]==0){
                    descubreCeros(x,y-1);
                }else{
                    //tablero[x][y-1]=8;

                    //tablero[x-1][y-1]=8;

                    int dato=Integer.parseInt( String.valueOf(x)+00+String.valueOf(y-1));
                    descubreBotones(dato);


                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x+1][y-1]==0){
                    descubreCeros(x+1,y-1);
                }else{
                    //tablero[x+1][y-1]=8;


                    int dato=Integer.parseInt( String.valueOf(x+1)+00+String.valueOf(y-1));
                    descubreBotones(dato);


                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x-1][y]==0){
                    descubreCeros(x-1,y);
                }else{
                    //tablero[x-1][y]=8;

                    int dato=Integer.parseInt( String.valueOf(x-1)+00+String.valueOf(y));
                    descubreBotones(dato);


                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x+1][y]==0){
                    descubreCeros(x+1,y);
                }else{
                    //tablero[x+1][y]=8;

                    int dato=Integer.parseInt( String.valueOf(x+1)+00+String.valueOf(y));
                    descubreBotones(dato);


                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x-1][y+1]==0){
                    descubreCeros(x-1,y+1);
                }else{
                    //tablero[x-1][y+1]=8;


                    int dato=Integer.parseInt( String.valueOf(x-1)+00+String.valueOf(y+1));
                    descubreBotones(dato);

                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x][y+1]==0){
                    descubreCeros(x,y+1);
                }else{
                    //tablero[x][y+1]=8;

                    int dato=Integer.parseInt( String.valueOf(x)+00+String.valueOf(y+1));
                    descubreBotones(dato);

                };
            }catch (ArrayIndexOutOfBoundsException e){}
            try{
                if(tablero[x+1][y+1]==0){
                    descubreCeros(x+1,y+1);
                }else{
                    //tablero[x+1][y+1]=8;


                    int dato=Integer.parseInt( String.valueOf(x+1)+00+String.valueOf(y+1));
                    descubreBotones(dato);
                };
            }catch (ArrayIndexOutOfBoundsException e){}

        }


    }

    public void descubreBotones(int id){


        Button boton= (Button) findViewById(id);

        if(boton.getText().equals("0")){

            boton.setTextColor(Color.BLACK);

        }else if(boton.getText().equals("1")){

            boton.setTextColor(Color.BLUE);


        }else if(boton.getText().equals("2")){

            boton.setTextColor(Color.GREEN);

        }else{

            boton.setTextColor(Color.RED);

        }

        boton.setBackgroundColor(Color.rgb(255, 2555, 255)); //con esto la casilla se pone de color blanco


        boton.setEnabled(false);
    }



    /**
     * Método para la selección de bandera
     * @param elementoSeleccionado
     */
    @Override
    public void respuestaDialogoPersonaje(int elementoSeleccionado) {


        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("Personaje", String.valueOf(elementoSeleccionado));
        editor.apply();

        //Toast.makeText(getApplicationContext(),"Bandera seleccionada:"+elementoSeleccionado,Toast.LENGTH_LONG ).show();
    }

    /**
     * Método para reiniciar el juego
     */
    public void reiniciarJuego(){
        // Creamos un objeto de tipo intent para poder referenciar la actividad actual:
        Intent intent=new Intent();
        intent.setClass(this, this.getClass());
        //llamamos a la actividad
        this.startActivity(intent);
        //finalizamos la actividad actual
        this.finish();
    }

    /**
     * Método para actualizar el contador de bombas
     */
    public void actualizaContadorBombas(TextView textoBombas){
        // Declaramos las variables necesarias:
        String numBombas = textoBombas.getText().toString();
        int bombasContador = Integer.parseInt(numBombas);
        // Restamos uno al contador de bombas siempre que sea superior o igual a cero:
        bombasContador = bombasContador-1;
        if(bombasContador>=0) {
            // Actualizamos el texto del contador:
            textoBombas.setText("" + bombasContador);
        }

    }



}


