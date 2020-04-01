import numpy as np
from scipy.integrate import odeint
import matplotlib.pyplot as plt
import matplotlib.animation as animation
from matplotlib.widgets import Slider

# numerische Parameter
tmax = 1600 # Endzeit
npnts = 2000 # Anzahl von Punkten
t = np.linspace(0,tmax,npnts)

# Anfangsbedingungen
S0 = 0.999
R0 = 0
I0 = 1-S0-R0
y0 = np.array([S0, I0, R0])

def f(y,t,beta,gamma):
    S,I,R = y
    dS = -beta*I*S
    dI = (beta*S - gamma)*I
    dR = gamma*I
    return np.array([dS,dI,dR])

fig, ax = plt.subplots()

# create a space in the figure to place the two sliders:
axcolor = 'lightgoldenrodyellow'
axis_beta = fig.add_axes([0.25, 0.95 ,0.5, 0.02], facecolor=axcolor)
axis_gamma = fig.add_axes([0.25, 0.9, 0.5, 0.02], facecolor=axcolor)
# the first argument is the rectangle, with values in percentage of the figure
# size: [left, bottom, width, height]

# Slider
slider_beta  = Slider(axis_beta,  'β', 0, .3, valinit=0.2)
slider_gamma = Slider(axis_gamma, 'γ', 0, .3, valinit=0.07)


def update(val):
    beta = slider_beta.val
    gamma = slider_gamma.val
    # update curve
    #l.set_ydata(amp*np.sin(t+slider_gamma.val))
    # redraw canvas while idle
    fig.canvas.draw_idle()
    y = odeint(f, y0, t, (beta, gamma))

    S,I,R = y[:,0], y[:,1], y[:,2]
    ax.clear()
    imax = np.argmax(I)
    ax.text(0.05*tmax,1.01, "Maximum: %.3g%% (t=%.1fd)" % (I[imax]*100, t[imax]))
    ax.plot(t, S, label="S", color="blue")
    ax.plot(t, I, label="I", color="red")
    ax.plot(t, R, label="R", color="green")
    ax.legend()
    ax.set_xlabel("Tage")
    ax.set_ylabel("Anteil der Bevölkerung")
    ax.grid(True)

# call update function on slider value change
slider_beta.on_changed(update)
slider_gamma.on_changed(update)
update(0)

plt.show()
