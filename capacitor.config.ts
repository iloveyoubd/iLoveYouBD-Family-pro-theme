import { CapacitorConfig } from '@capacitor/cli';

const config: CapacitorConfig = {
  appId: 'com.iloveyoubd.neonpro',
  appName: 'ILoveYouBD Family Pro',
  webDir: 'dist',
  server: {
    androidScheme: 'https'
  },
  plugins: {
    SplashScreen: {
      launchShowDuration: 3000,
      launchAutoHide: true,
      backgroundColor: "#070a10",
      androidScaleType: "CENTER_CROP"
    }
  }
};

export default config;
