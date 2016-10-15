using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace AiderApp.Views
{
    public partial class OutputView : Form
    {
        Form1 parent;

        public OutputView(Form1 parent)
        {
            this.parent = parent;
            InitializeComponent();
            this.Visible = false;
        }

        //go back to search view
        private void button1_Click(object sender, EventArgs e)
        {
            parent.Location = this.Location;
            this.Visible = false;
            parent.Visible = true;
        }

        //close application
        private void button2_Click(object sender, EventArgs e)
        {
            parent.Close();
        }

        public void updateOutput(String output)
        {
            outputLabel.Text = output;
        }
    }
}
