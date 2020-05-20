package com.example.david.buscaminas;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.app.DialogFragment;
import android.content.DialogInterface;
import android.os.Bundle;

/**
 * Created by David on 20/11/2017.
 */

public class DialogoPersonaje extends DialogFragment {
    // Instanciamos  la interfaz para poder controlar los eventos entre los dialogos y el activity principal:
    respuestaDialogoPersonaje respuesta;

    String personaje;

    //metodo para conseguir la dificultad
    public void damePersonaje(String personaje){
        this.personaje=personaje;



    }


    /**
     * Método que se ejecuta cuando la actividad principal ejecuta el show()
     * Cuando el usuario selecciona una opción, se desencadena la llamada la funcion
     * de callback onRespuesta y se cierra el dialogo
     * @param savedInstanceState
     * @return
     */
    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {

        // Usamos la clase Builder para construir el diálogo
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        // Creamos un array de char para los diferentes RadioButtons:
        final CharSequence[] items = new CharSequence[3];

        items[0] = "Tipo 1";
        items[1] = "Tipo 2";
        items[2] = "Tipo 3";

        // Establecemos la imagen de la bandera por defecto
        int modo= Integer.parseInt(personaje);

        // Establecemos el título:
        builder.setTitle("Tipo de bandera");
        // Establecemos una selección simple, pasandole el array de elementos,el elemento por defecto y el evento:
        builder.setSingleChoiceItems(items,modo, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int elementoSeleccionado) {
                // Al seleccionar un elemento pasamos el elemento seleccionado al método de la interfaz onRespuesta:
                respuesta.respuestaDialogoPersonaje(elementoSeleccionado);
                // Cerramos el dialogo después que el usuario seleccione una opción:
                dialog.dismiss();
            }

        });

        // Creamos el AlertDialog y lo devolvemos:
        return builder.create();
    }

    /**
     * Interfaz que contiene el método respuestaDialogoPersonaje que implementaremos
     * en la clase que lo usemos:
     */
    public interface respuestaDialogoPersonaje {
        public void respuestaDialogoPersonaje(int elementoSeleccionado);

    }

    /**
     * Permite unir la actividad principal a la interfaz
     * @param activity
     */
    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);

        try {
            respuesta = (respuestaDialogoPersonaje) activity;

        } catch (ClassCastException e) {
            throw new ClassCastException(
                    activity.toString() +
                            " no implementó OnSimpleDialogListener");

        }
    }
}
